<?php

namespace Users\View\Cell;

use Cake\View\Cell;

/**
 * Logs cell
 */
class LogsCell extends Cell {

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function recent($limit = 3) {
        $this->loadModel('Users.Logs');
        $logs = $this->Logs->find()
                ->select(['ip', 'browser', 'created'])
                ->where(['user_id' => $this->request->session()->read('Auth.User.id')])
                ->orderDesc('id')
                ->limit($limit);

        $this->set('logs', $logs);
    }

}
