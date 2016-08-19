<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 17.08.16
 * Time: 20:39
 */
namespace speedy;

use speedyPack\phpFunc\CompareTest;

class Speedy {

    const PHP_INC_PREF_POST = 'speedyPack\phpFunc\IncPrefVsPos';

    public static function test($test, $params = [], $onlyData = false)
    {
        $test = new $test();
        foreach($params as $key => $value) {
            if(isset($test->$key)) {
                $test->$key = $value;
            }
        }

        return $test->run($onlyData);
    }

    public static function compare($func = [], $params = [], $onlyData = false)
    {
        $test = new CompareTest($func);

        foreach($params as $key => $value) {
            if(isset($test->$key)) {
                $test->$key = $value;
            }
        }

        return $test->run($onlyData);
    }
} 