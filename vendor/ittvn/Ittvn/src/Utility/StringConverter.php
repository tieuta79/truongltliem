<?php

namespace Ittvn\Utility;

class StringConverter {

    public static function parseString($exp, $text) {
        $output = [];
        preg_match_all('/\[' . $exp . ' (.*?)\]/i', $text, $matches);        
        if (isset($matches[0]) && count($matches[0]) > 0) {
            foreach ($matches[2] as $k => $matche) {
                preg_match_all('/(\S+)=[\'"]?((?:.(?![\'"]?\s+(?:\S+)=|[>\'"]))+.)[\'"]?/i', $matche, $attributes);
                if (isset($attributes[0]) && count($attributes[0]) > 0) {
                    $output[$matches[1][$k]]['text'] = $matches[0][$k];
                    foreach ($attributes[0] as $k1 => $attribute) {
                        $output[$matches[1][$k]][$attributes[1][$k1]] = $attributes[2][$k1];
                    }
                }
            }
        }

        return $output;
    }

    public function stringToArray($string) {
        $string = explode(';', $string);
        $stringArr = array();
        foreach ($string as $stringElement) {
            if ($stringElement != null) {
                $stringElementE = explode(':', $stringElement);
                if (isset($stringElementE['1'])) {
                    $value = $stringElementE['1'];
                    if (strpos($value, ',') !== false) {
                        $value = explode(',', $value);
                    }
                    $stringArr[$stringElementE['0']] = $value;
                } else {
                    $stringArr[] = $stringElement;
                }
            }
        }
        return $stringArr;
    }

    public function linkStringToArray($link, $options = array()) {
        static $cached = array();
        $options = array_merge(array(
            'useCache' => true,
                ), $options);
        $useCache = $options['useCache'];

        $hash = md5($link);
        if (isset($cached[$hash])) {
            return $cached[$hash];
        }

        if (is_array($link)) {
            $link = key($link);
        }
        if (($pos = strpos($link, '?')) !== false) {
            parse_str(substr($link, $pos + 1), $query);
            $link = substr($link, 0, $pos);
        }
        $link = explode('/', $link);
        $prefixes = Configure::read('Routing.prefixes');
        $linkArr = array_fill_keys($prefixes, false);
        foreach ($link as $linkElement) {
            if ($linkElement != null) {
                $linkElementE = explode(':', $linkElement);
                if (isset($linkElementE['1'])) {
                    if (in_array($linkElementE['0'], $prefixes)) {
                        $linkArr[$linkElementE['0']] = strcasecmp($linkElementE['1'], 'false') === 0 ? false : true;
                    } else {
                        $linkArr[$linkElementE['0']] = urldecode($linkElementE['1']);
                    }
                } else {
                    $linkArr[] = $linkElement;
                }
            }
        }
        if (!isset($linkArr['plugin'])) {
            $linkArr['plugin'] = false;
        }

        if (isset($query)) {
            $linkArr['?'] = $query;
        }

        $cached[$hash] = $linkArr;
        return $linkArr;
    }

    public function urlToLinkString($url) {
        $result = array();
        $actions = array_merge(array(
            'admin' => false, 'plugin' => false,
            'controller' => false, 'action' => false
                ), $url
        );
        $queryString = null;
        foreach ($actions as $key => $val) {
            if (is_string($key)) {
                if (is_bool($val)) {
                    if ($val === true) {
                        $result[] = $key;
                    }
                } elseif ($key == '?') {
                    $queryString = '?' . http_build_query($val);
                } else {
                    $result[] = $key . ':' . $val;
                }
            } else {
                $result[] = $val;
            }
        }
        return join('/', $result) . $queryString;
    }

}
