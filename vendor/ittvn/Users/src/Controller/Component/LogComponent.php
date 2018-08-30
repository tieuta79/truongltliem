<?php

namespace Users\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Core\Configure;
use Cake\Core\App;
use Cake\Utility\Inflector;
use Settings\Utility\Setting;
use Cake\ORM\TableRegistry;
use Cake\Event\EventDispatcherTrait;
use Cake\Event\EventManager;
use Cake\Utility\Hash;
use Ittvn\Utility\User;

class LogComponent extends Component {

    use EventDispatcherTrait;

    public function implementedEvents() {
        $events = parent::implementedEvents();
        return Hash::merge($events, [
                    'Controller.Admin.Users.successLogin' => [
                        'callable' => 'successLogin',
                        'priority' => 100
                    ],
                    'Controller.User.Users.successLogin' => [
                        'callable' => 'successLogin',
                        'priority' => 100
                    ],
        ]);
    }

    public function successLogin(Event $event) {
        $Logs = TableRegistry::get('Users.Logs');
        $log = $Logs->newEntity([
            'user_id' => $event->subject()->Auth->user('id'),
            'ip' => $this->request->clientIp(),
            'browser' => $this->request->header('User-Agent'),
        ]);
        $Logs->save($log);
    }
    
    public function beforeRender(Event $event) {
        if (!$this->request->is('ajax')) {
            if ($event->subject()->Auth->user('id')) {
                $Logs = TableRegistry::get('Users.Logs');
                $log = $Logs->find()
                        ->where(['user_id' => $event->subject()->Auth->user('id')])
                        ->orderDesc('id')
                        ->firstOrFail();

                if ($log && $log->created->format('d-m-Y') == date('d-m-Y')) {
                    $UsersLogs = TableRegistry::get('Users.UsersLogs');

                    $checkLog = $UsersLogs->find()
                            ->where([
                                'log_id' => $log->id,
                                'url' => $this->request->here()
                            ])
                            ->andWhere(function($exp, $q) {
                                $created = $q->func()->date_format([
                                    'created' => 'identifier',
                                    "'%Y-%m-%d %H'" => 'literal'
                                ]);
                                return $exp->eq($created, date('Y-m-d H'));
                            })
                            ->orderDesc('id');

                    if ($checkLog->count() == 0) {
                        $usersLog = $UsersLogs->newEntity([
                            'log_id' => $log->id,
                            'url' => $this->request->here(),
                            'params' => $this->request->params,
                            'query' => $this->request->query,
                            'data' => $this->request->data,
                        ]);
                        $UsersLogs->save($usersLog);
                    }
                }
            }
        }      
    }
}
