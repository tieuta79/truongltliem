<?php

use Migrations\AbstractSeed;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Settings\Utility\Setting;
use Ittvn\Utility\Language;
/**
 * Settings seed.
 */
class LanguagesSeed extends AbstractSeed {

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
		$lang = (new Setting())->getOption('Languages.site');
        //$languages = TableRegistry::get('Extensions.Languages')->find()->select(['name', 'code', 'image', 'class', 'delete']);
        if (Language::getLanguages()->count() > 0) {
            $languages = Language::$languages;
            $data = [];
            foreach ($languages as $k => $v) {
                $data[$k]['name'] = $v->name;
                $data[$k]['code'] = $v->code;
                $data[$k]['image'] = $v->image;
                $data[$k]['class'] = $v->class;
				if($lang == $v->code){
					$data[$k]['status'] = 1;
				}else{
					$data[$k]['status'] = 0;
				}                
                $data[$k]['delete'] = $v->delete;
            }
            $table = $this->table('languages');
            $table->insert($data)->save();
        }
    }

}
