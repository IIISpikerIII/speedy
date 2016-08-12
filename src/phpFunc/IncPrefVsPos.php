<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 01.08.16
 * Time: 21:41
 */
namespace speedy\phpFunc;

use speedy\config\App;
use speedy\dataViewers\GraphBuble;
use speedy\dataViewers\TableGroup;
use speedy\dataViewers\TableList;
use speedy\interfaces\TestAbstract;
use speedy\interfaces\TestInterface;

class IncPrefVsPos extends TestAbstract implements TestInterface {

    public $valueTest = [/*10, 100, 1000, 10000, 100000, 500000,*/ 100, 1000, 2000, 3000];
    public $qntTest = 5;

    public function render() {
        $data = $this->getData();
        print TableList::model()->run($data);
        print TableGroup::model()->run($data);
        //print GraphBuble::model()->run($data);

        print App::render('test_result.php', compact('data'));
    }

    public function itemTest($size)
    {
        //variable set for memory
        $time1 = $this->testPost($size);
        $time2 = $this->testPref($size);
        $part = $this->generatePart();

        $time1 = $this->testPost($size);
        $time2 = $this->testPref($size);
        $this->setData('Post', $size, $time1['time'], $part, $time1['memory'],'->');
        $this->setData('Pre', $size, $time2['time'], $part, $time2['memory'], '->');

        $part = $this->generatePart();
        $time2 = $this->testPref($size);
        $time1 = $this->testPost($size);
        $this->setData('Post', $size, $time1['time'], $part, $time1['memory'], '<-');
        $this->setData('Pre', $size, $time2['time'], $part, $time2['memory'], '<-');
    }

    public function testPref($size)
    {
        $testCounter = 0;
        $memory = $this->getMemory();
        $time = $this->getTime();
        for($i=0;$i<$size;$i++) {
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
        }
        $time = $this->getTime($time);
        $memory = $this->getMemory($memory);
        return ['memory' => $memory, 'time' => $time];
    }

    public function testPost($size)
    {
        $testCounter = 0;
        $memory = $this->getMemory();
        $time = $this->getTime();
        for($i=0;$i<$size;$i++) {
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
        }
        $time = $this->getTime($time);
        $memory = $this->getMemory($memory);
        return ['memory' => $memory, 'time' => $time];
    }
}