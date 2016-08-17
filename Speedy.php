<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 17.08.16
 * Time: 20:39
 */
namespace speedy;

class Speedy {

    const PHP_INC_PREF_POST = 'speedyPack\phpFunc\IncPrefVsPos';

    public static function test($test, $params = [])
    {
        $test = new $test();

        foreach($params as $key => $value) {
            if(isset($test->$key)) {
                $test->$key = $value;
            }
        }
        $test->run();
    }
} 