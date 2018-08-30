<?php

namespace Ittvn\Utility;

use InvalidArgumentException;
use RuntimeException;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Utility\Security;

class Encryption {

    static function encrypt($string = null, $key = 'truonghocketnoi.vn') {
        if (!empty($string)) {
            $encrypt = Security::encrypt($string, Security::salt() . $key);
            $encrypt = strtr(base64_encode($encrypt), '+/=', '-_,');
            return $encrypt;
        }
        return $string;
    }

    static function decrypt($string = null, $key = 'truonghocketnoi.vn') {
        if (!empty($string)) {
            $decrypt = base64_decode(strtr($string, '-_,', '+/='));
            $decrypt = Security::decrypt($decrypt, Security::salt() . $key);
            return $decrypt;
        }
        return $string;
    }

}
