<?php

namespace Ittvn\Utility;

use InvalidArgumentException;
use RuntimeException;
use Ittvn\Utility\StringConverter;
use Cake\View\View;

class Shortcode {

    private static $shortcode = null;

    public static function add($shortcode = null, $callback) {
        if (!empty($shortcode) && !empty($callback)) {
            self::$shortcode[$shortcode] = $callback;
        }
    }

    public static function runs($string = null) {
        if (!empty($string) && !empty(self::$shortcode)) {
            $shortcodes = array_keys(self::$shortcode);
            $validShortcode = self::split($string, $shortcodes);            
            if (!empty($validShortcode) && count($validShortcode) > 0) {
                foreach ($validShortcode as $key => $shortcode) {
                    $string = self::run($string, $key, $shortcode);
                }
            }
        }
        return $string;
    }

    public static function run($string, $shortcode, $attributes) {
        $attributes = (array) $attributes;
        if (isset(self::$shortcode[$shortcode])) {
            $text = $attributes['text'];
            unset($attributes['text']);
            if (is_callable(self::$shortcode[$shortcode])) {
                $callback = call_user_func(self::$shortcode[$shortcode], $attributes);                
            } else if (strpos(self::$shortcode[$shortcode], '::') == true) {
                $view = new View();
                $callback = $view->cell(self::$shortcode[$shortcode], ['attributes' => $attributes]);
            }
            if($callback){
                $string = str_replace($text, $callback, $string);
            }            
        }
        return $string;
    }

    private static function split($string, $shortcodes) {
        if(!empty($shortcodes) && count($shortcodes) > 0){
            $shortcode = '(' . implode('|', $shortcodes) . ')';
            return StringConverter::parseString($shortcode, $string);
        }
        return false;
    }

}
