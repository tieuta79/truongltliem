<?php
namespace Ittvn\Utility;

use InvalidArgumentException;
use RuntimeException;
use Cake\Core\Configure;
use Settings\Utility\Setting;
use Cake\I18n\I18n;
use Cake\Network\Request;
use Cake\Routing\Router;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Component\CookieComponent;
use Cake\ORM\TableRegistry;
use Cake\Collection\Collection;

class Language {

    public static $languages = null;

    static function setLanguage() {
        /*
          $setting = new Setting();
          $langd = $setting->getOption('Sites.language_default');
          $langs = $setting->getOption('Languages.site');
          $langa = $setting->getOption('Languages.admin');

          if (strpos(Request::createFromGlobals()->here(), 'admin') == false) {
          $cookie = isset($_COOKIE['lang']) ? $_COOKIE['lang'] : $langs;
          if (!$cookie) {
          if (!empty($langs)) {
          ini_set('intl.default_locale', $langs);
          I18n::locale($langs);
          } else {
          ini_set('intl.default_locale', $langd);
          I18n::locale($langd);
          }
          } else {
          I18n::locale($cookie);
          }
          } else {
          $Collection = new ComponentRegistry();
          $cookie = new CookieComponent($Collection);
          $cookie->config([
          'path' => '/',
          'expires' => '+10 days',
          'httpOnly' => true,
          'key' => 'ce1447b92033af63cb807ae0ada08ittvn2c76e60eeedd6d45a243e98224bd0e204fb'
          ]);

          if (!$cookie->check('language.admin')) {
          if (!empty($langa)) {
          ini_set('intl.default_locale', $langa);
          I18n::locale($langa);
          } else {
          ini_set('intl.default_locale', $langd);
          I18n::locale($langd);
          }
          } else {
          I18n::locale($cookie->read('language.admin'));
          }
          }
         * 
         */
    }

    static function getLanguages() {
        if (!empty(self::$languages) && is_object(self::$languages)) {
            return self::$languages;
        }
        
        $Language = TableRegistry::get('Extensions.Languages');
        $languages = $Language->find()->find('network')->where(['Languages.status' => 1, 'Languages.delete' => 0]);
        self::$languages = $languages;
        return $languages;
    }

    static function getLanguage($lang = null, $prefix = 'auto') {
        if (empty(self::$languages) || self::$languages->count() == 0) {
            self::getLanguages();
        }

        if (empty($lang)) {
            $setting = new Setting();
            switch ($prefix) {
                case false:
                    $lang = $setting->getOption('Languages.site');
                    break;
                case 'admin':
                    $lang = $setting->getOption('Languages.admin');
                    break;
                default :
                    $request = Router::getRequest();
                    if ($request->prefix == false) {
                        $lang = $setting->getOption('Languages.site');
                    } else if ($request->prefix == 'admin') {
                        $lang = $setting->getOption('Languages.admin');
                    }
                    break;
            }
        }

        $language = (new Collection(self::$languages))->firstMatch([
            'code' => $lang
        ]);
        return $language;
    }

    static function checkLanguage($lang) {
        if (empty(self::$languages) || self::$languages->count() == 0) {
            self::getLanguages();
        }

        if (!empty($lang)) {
            $language = (new Collection(self::$languages))->firstMatch([
                'code' => $lang
            ]);
            
            if($language->count() > 0){
                return true;
            }
        }
        return false;
    }

}
