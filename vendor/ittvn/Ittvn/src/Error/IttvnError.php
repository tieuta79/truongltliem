<?php

namespace Ittvn\Error;

use Cake\Error\BaseErrorHandler;
use Cake\Controller\Controller;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception as CakeException;
use Cake\Core\Exception\MissingPluginException;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Network\Exception\HttpException;
use Cake\Routing\DispatcherFactory;
use Cake\Routing\Router;
use Cake\Utility\Inflector;
use Cake\View\Exception\MissingTemplateException;
use Exception;
use PDOException;
use Cake\ORM\TableRegistry;
use Settings\Utility\Setting;
use Ittvn\Utility\User;

class IttvnError extends BaseErrorHandler {

    public $error;
    public $controller;
    public $template = '';
    public $method = '';

    public function _displayError($error, $debug) {
        if (!Configure::read('debug')) {
            $this->request = Router::getRequest();
            $url_path = $this->request->here;
            $Redirecturls = TableRegistry::get('Extensions.Redirecturls');
            $redirect = $Redirecturls->find()->find('network')
                        ->where(['request' => $url_path]);
            if($redirect->count() > 0){
                if (empty($redirect->first()->options)) {
                    $redirect = $redirect->first();                    
                    $redirect->code = 0;
                    $redirect->options = json_encode($error);
                    $Redirecturls->saveNetwork($redirect);
                }
            }else
            {
                $redirect = $Redirecturls->newEntity();
                $redirect->request = $url_path;
                $redirect->code = 0;
                $redirect->options = json_encode($error);
                $Redirecturls->saveNetwork($redirect);
            }
            
            //echo 'There has been an error!';
        }
    }

    public function _displayException($exception) {
        if (!Configure::read('debug')) {
            $settings = new Setting();
            $this->request = Router::getRequest();
            $this->Redirecturls = TableRegistry::get('Extensions.Redirecturls');
            $url_path = $this->request->here;

            $this->error = $exception;

            $this->controller = $this->_getController();
            $urltarget = '';
            if ($this->request->param('prefix') === 'admin') {
                $this->controller->viewBuilder()->theme($settings->getOption('Themes.admin'));
            } else {
                $this->controller->viewBuilder()->theme($settings->getOption('Themes.site'));
                $redirect = $this->Redirecturls->find()->find('network')
                        ->where(['request' => $url_path]);
                if ($redirect->count() > 0) {
                    $urltarget = $this->redirecturl($url_path, true);
                    if (empty($redirect->first()->msg)) {
                        $redirect = $redirect->first();
                        $redirect->msg = $exception->getMessage();
                        $redirect->code = $exception->getcode();
                        $this->Redirecturls->saveNetwork($redirect);
                    }
                } else {
                    $urltarget = $this->redirecturl($url_path, false);
                    $redirect = $this->Redirecturls->newEntity();
                    $redirect->request = $url_path;
                    $redirect->code = $exception->getcode();
                    $redirect->msg = $exception->getMessage();
                    $this->Redirecturls->saveNetwork($redirect);
                }
            }
            if (!empty($urltarget)) {
                $this->controller->redirect($urltarget);
            }
            //$this->controller->viewBuilder()->helpers(['Ittvn.Layout']);
            $this->controller->viewClass = 'Ittvn.Admin';
            $this->controller->set('title_for_layout', 'Not Found');
            $this->controller->render('error400');
            $this->controller->response->send();
        }
    }

    public function handleFatalError($code, $description, $file, $line) {
        return 'A fatal error has happened';
    }

    protected function _unwrap($exception) {
        return $exception instanceof PHP7ErrorException ? $exception->getError() : $exception;
    }

    protected function _getController() {
        if (!$request = Router::getRequest(true)) {
            $request = ServerRequest::createFromGlobals();
        }
        $response = new Response();
        $controller = null;

        try {
            $class = App::className('Error', 'Controller', 'Controller');
            /* @var \Cake\Controller\Controller $controller */
            $controller = new $class($request, $response);
            $controller->startupProcess();
            $startup = true;
        } catch (Exception $e) {
            $startup = false;
        }

        if ($startup === false && !empty($controller) && isset($controller->RequestHandler)) {
            try {
                $event = new Event('Controller.startup', $controller);
                $controller->RequestHandler->startup($event);
            } catch (Exception $e) {
                
            }
        }
        if (empty($controller)) {
            $controller = new Controller($request, $response);
        }

        return $controller;
    }

    public function redirecturl($path, $flag) {
        if ($flag) {
            $request = Router::getRequest();
            $redirecturls = TableRegistry::get('Extensions.Redirecturls')->find()
                            ->find('network')
                            ->select(['Redirecturls.id', 'Redirecturls.request', 'Redirecturls.target'])
                            ->where(['request' => $path])->first();
            if (!empty($redirecturls->target)) {
                return $redirecturls->target;
            }
        }
        return null;
    }

    public function render() {
        $exception = $this->error;
        $code = $this->_code($exception);
        $method = $this->_method($exception);
        $template = $this->_template($exception, $method, $code);
        $unwrapped = $this->_unwrap($exception);

        $isDebug = Configure::read('debug');
        if (($isDebug || $exception instanceof HttpException) &&
                method_exists($this, $method)
        ) {
            return $this->_customMethod($method, $unwrapped);
        }

        $message = $this->_message($exception, $code);
        $url = $this->controller->request->getRequestTarget();

        if ($exception instanceof CakeException) {
            $this->controller->response->header($exception->responseHeader());
        }
        $this->controller->response->statusCode($code);
        $viewVars = [
            'message' => $message,
            'url' => h($url),
            'error' => $unwrapped,
            'code' => $code,
            '_serialize' => ['message', 'url', 'code']
        ];
        if ($isDebug) {
            $viewVars['trace'] = Debugger::formatTrace($unwrapped->getTrace(), [
                        'format' => 'array',
                        'args' => false
            ]);
            $viewVars['file'] = $exception->getFile() ?: 'null';
            $viewVars['line'] = $exception->getLine() ?: 'null';
            $viewVars['_serialize'][] = 'file';
            $viewVars['_serialize'][] = 'line';
        }
        $this->controller->set($viewVars);

        if ($unwrapped instanceof CakeException && $isDebug) {
            $this->controller->set($unwrapped->getAttributes());
        }

        return $this->_outputMessage($template);
    }

    /**
     * Render a custom error method/template.
     *
     * @param string $method The method name to invoke.
     * @param \Exception $exception The exception to render.
     * @return \Cake\Http\Response The response to send.
     */
    protected function _customMethod($method, $exception) {
        $result = call_user_func([$this, $method], $exception);
        $this->_shutdown();
        if (is_string($result)) {
            $this->controller->response->body($result);
            $result = $this->controller->response;
        }

        return $result;
    }

    /**
     * Get method name
     *
     * @param \Exception $exception Exception instance.
     * @return string
     */
    protected function _method(Exception $exception) {
        $exception = $this->_unwrap($exception);
        list(, $baseClass) = namespaceSplit(get_class($exception));

        if (substr($baseClass, -9) === 'Exception') {
            $baseClass = substr($baseClass, 0, -9);
        }

        $method = Inflector::variable($baseClass) ?: 'error500';

        return $this->method = $method;
    }

    /**
     * Get error message.
     *
     * @param \Exception $exception Exception.
     * @param int $code Error code.
     * @return string Error message
     */
    public function _message(Exception $exception, $code) {
        $exception = $this->_unwrap($exception);
        $message = $exception->getMessage();

        if (!Configure::read('debug') &&
                !($exception instanceof HttpException)
        ) {
            if ($code < 500) {
                $message = __d('cake', 'Not Found');
            } else {
                $message = __d('cake', 'An Internal Error Has Occurred.');
            }
        }

        return $message;
    }

    /**
     * Get template for rendering exception info.
     *
     * @param \Exception $exception Exception instance.
     * @param string $method Method name.
     * @param int $code Error code.
     * @return string Template name
     */
    public function _template(Exception $exception, $method, $code) {
        $exception = $this->_unwrap($exception);
        $isHttpException = $exception instanceof HttpException;

        if (!Configure::read('debug') && !$isHttpException || $isHttpException) {
            $template = 'error500';
            if ($code < 500) {
                $template = 'error400';
            }

            return $this->template = $template;
        }

        $template = $method ?: 'error500';

        if ($exception instanceof PDOException) {
            $template = 'pdo_error';
        }

        return $this->template = $template;
    }

    /**
     * Get an error code value within range 400 to 506
     *
     * @param \Exception $exception Exception.
     * @return int Error code value within range 400 to 506
     */
    public function _code(Exception $exception) {
        $code = 500;
        $exception = $this->_unwrap($exception);
        $errorCode = $exception->getCode();
        if ($errorCode >= 400 && $errorCode < 506) {
            $code = $errorCode;
        }

        return $code;
    }

    /**
     * Generate the response using the controller object.
     *
     * @param string $template The template to render.
     * @return \Cake\Http\Response A response object that can be sent.
     */
    public function _outputMessage($template) {
        try {
            $this->controller->render($template);

            return $this->_shutdown();
        } catch (MissingTemplateException $e) {
            $attributes = $e->getAttributes();
            if (isset($attributes['file']) && strpos($attributes['file'], 'error500') !== false) {
                return $this->_outputMessageSafe('error500');
            }

            return $this->_outputMessage('error500');
        } catch (MissingPluginException $e) {
            $attributes = $e->getAttributes();
            if (isset($attributes['plugin']) && $attributes['plugin'] === $this->controller->plugin) {
                $this->controller->plugin = null;
            }

            return $this->_outputMessageSafe('error500');
        } catch (Exception $e) {
            return $this->_outputMessageSafe('error500');
        }
    }

    /**
     * A safer way to render error messages, replaces all helpers, with basics
     * and doesn't call component methods.
     *
     * @param string $template The template to render.
     * @return \Cake\Http\Response A response object that can be sent.
     */
    public function _outputMessageSafe($template) {
        $helpers = ['Form', 'Html'];
        $this->controller->helpers = $helpers;
        $builder = $this->controller->viewBuilder();
        $builder->setHelpers($helpers, false)
                ->setLayoutPath('')
                ->setTemplatePath('Error');
        $view = $this->controller->createView('View');

        $this->controller->response->body($view->render($template, 'error'));
        $this->controller->response->type('html');

        return $this->controller->response;
    }

    /**
     * Run the shutdown events.
     *
     * Triggers the afterFilter and afterDispatch events.
     *
     * @return \Cake\Http\Response The response to serve.
     */
    protected function _shutdown() {
        $this->controller->dispatchEvent('Controller.shutdown');
        $dispatcher = DispatcherFactory::create();
        $eventManager = $dispatcher->getEventManager();
        foreach ($dispatcher->filters() as $filter) {
            $eventManager->on($filter);
        }
        $args = [
            'request' => $this->controller->request,
            'response' => $this->controller->response
        ];
        $result = $dispatcher->dispatchEvent('Dispatcher.afterDispatch', $args);

        return $result->getData('response');
    }

}

?>