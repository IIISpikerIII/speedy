<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 01.08.16
 * Time: 21:41
 */
namespace speedy\phpFunc;

use speedy\helpers\ArrayHelper;

class IncPrefVsPos {

    public function getTime(){
        return microtime(true);
    }

    public function run()
    {
        ini_set('memory_limit', 512000000);

        $params = [/*10, 100, 1000, 10000, 100000, 500000,*/ 100000, 1000000];

        foreach($params as $size) {
            print('SIZE: ' . $size . '<br/>');

            $time1 = $this->testPost($size);
            $time2 = $this->testPref($size);
            print(($time1 < $time2?'*':'').'Post: '.$time1.'<br/>');
            print(($time2 < $time1?'*':'').'Pref: '.$time2.'<br/>');

            $time2 = $this->testPref($size);
            $time1 = $this->testPost($size);
            print(($time2 < $time1?'*':'').'Pref: '.$time2.'<br/>');
            print(($time1 < $time2?'*':'').'Post: '.$time1.'<br/>');
            print('-----------------------<br/>');
        }
    }

    public function testPref($size)
    {
        $testCounter = 0;
        $startTime = $this->getTime();
        for($i=0;$i<$size;$i++) {
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
        }
        return ($this->getTime() - $startTime);
    }

    public function testPost($size)
    {
        $testCounter = 0;
        $startTime = $this->getTime();
        for($i=0;$i<$size;$i++) {
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
        }
        return ($this->getTime() - $startTime);
    }
}