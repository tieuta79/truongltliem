<?php 
namespace Ittvn\Controller;

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
class ErrorController extends Controller {
	public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);
        if (count(Router::extensions()) &&
            !isset($this->RequestHandler)
        ) {
            $this->loadComponent('RequestHandler');
        }
        $eventManager = $this->eventManager();
        if (isset($this->Auth)) {
            $eventManager->detach($this->Auth);
        }
        if (isset($this->Security)) {
            $eventManager->detach($this->Security);
        }
        $this->viewPath = 'Error';
    }
}
?>