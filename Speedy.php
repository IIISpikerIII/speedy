<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 17.08.16
 * Time: 20:39
 */
namespace speedy;

use speedyPack\interfaces\TestCore;
use speedyPack\phpFunc\CompareTest;

class Speedy {

    const PHP_INC_PREF_POST = 'speedyPack\phpFunc\IncPrefVsPos';
    const PHP_ARR_READ = 'speedyPack\phpFunc\ArrayRead';
    const PHP_SOF_VS_COUNT = 'speedyPack\phpFunc\SizeofVsCount';

    public static function test($test, $params = [], $onlyData = false)
    {
        $test = new $test();

        foreach($params as $key => $value) {

            if($key == 'tester') {
                $tester = self::getTester($value);
                $test->tester = $tester;
                continue;
            }

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

            if($key == 'tester') {
                $tester = self::getTester($value);
                $test->tester = $tester;
                continue;
            }

            if(isset($test->$key)) {
                $test->$key = $value;
            }
        }

        return $test->run($onlyData);
    }

    private static function getTester($testerParams)
    {
        if(!is_array($testerParams)) {
            return new $testerParams;
        }

        $tester = new $testerParams['name'];

        foreach($testerParams as $key => $value) {
            if(isset($tester->$key)) {
                $tester->$key = $value;
            }
        }
        return $tester;
    }

} 