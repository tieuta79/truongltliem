<?php

namespace Blocks\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;

class BlocksEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            'Cell.Admin.Tables.optionsAction' => 'updateBuyStatistic',
        ];
    }

    public function updateBuyStatistic(Event $event) {

    }

}
