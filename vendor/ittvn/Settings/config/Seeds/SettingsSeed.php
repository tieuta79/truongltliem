<?php

use Migrations\AbstractSeed;
use Settings\Utility\Setting;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * Settings seed.
 */
class SettingsSeed extends AbstractSeed {

    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run() {
        $settings = TableRegistry::get('Settings.Settings')->find()->select(['name', 'value', 'description', 'options', 'type', 'method', 'editable', 'order', 'global', 'delete'])->where(['global' => 0]);
        if ($settings->count() > 0) {
            $data = [];
            foreach ($settings as $k => $v) {
                $data[$k]['name'] = $v->name;
                $data[$k]['value'] = $v->value;
                $data[$k]['description'] = $v->description;
                $data[$k]['options'] = $v->options;
                $data[$k]['type'] = $v->type;
                $data[$k]['method'] = $v->method;
                $data[$k]['editable'] = $v->editable;
                $data[$k]['order'] = $v->order;
                $data[$k]['global'] = $v->global;
                $data[$k]['delete'] = $v->delete;
            }

            $config = new Setting();
            foreach ($data as $k => $d) {
                if ($d['name'] == 'Sites.title') {
                    $data[$k]['value'] = sprintf(__d('ittvn', '%s - New site'), $config->getOption('Sites.title'));
                }
            }

            $table = $this->table('settings');
            $table->insert($data)->save();
        }
    }

}
