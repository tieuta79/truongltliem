<?php

namespace Extensions\View\Cell;

use Cake\View\Cell;
use Settings\Utility\Setting;
use Cake\Utility\Hash;

/**
 * Languages cell
 */
class LanguagesCell extends Cell {

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
    public function display() {
        $this->loadModel('Extensions.Languages');
        $languages = $this->Languages->find()->find('network')->select(['id', 'name', 'code', 'image', 'class'])->where(['status' => 1, 'delete' => 0]);

        $setting = new Setting();
        //pr($languages->toArray());
        //die($setting->getOption('Languages.site'));
        $language_site = Hash::extract($languages->toArray(), '{n}[code=' . $setting->getOption('Languages.site') . ']');
        $language_admin = Hash::extract($languages->toArray(), '{n}[code=' . $setting->getOption('Languages.admin') . ']');

        $this->set('language_site', $language_site);
        $this->set('language_admin', $language_admin);
        $this->set('languages', $languages);
    }

}
