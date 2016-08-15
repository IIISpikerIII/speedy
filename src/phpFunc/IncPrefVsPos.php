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
use speedy\dataViewers\TableAvg;
use speedy\dataViewers\TableGroup;
use speedy\dataViewers\TableList;
use speedy\interfaces\TestAbstract;
use speedy\interfaces\TestInterface;

class IncPrefVsPos extends TestAbstract implements TestInterface {

    public $valueTest = [/*10, 100, 1000, 10000, 100000, 500000,*/ 100, 1000, 2000, 3000];
    public $qntTest = 5;

    public function render() {
        $data = $this->getData();
        $tableList = TableList::model()->run($data);
        $tableGroup = TableGroup::model()->run($data);
        $graphBuble  = GraphBuble::model()->run($data);
        $tableAvg = TableAvg::model()->run($data);

        $viewers = compact('tableList', 'tableGroup', 'tableAvg', 'graphBuble');
        print App::render('test_result.php', compact('viewers'));
    }

    public function itemTest($size)
    {
        $part = $this->generatePart();

        //variable set for memory
        $time1 = $this->speedTest('testPost', $size);
        $time2 = $this->speedTest('testPref', $size);
        $this->setData(self::DUMMY_NAME, $size, $time1['time'], $part, $time1['memory'],'->', self::DUMMY_NAME);
        $this->setData(self::DUMMY_NAME, $size, $time2['time'], $part, $time2['memory'], '->', self::DUMMY_NAME);

        $time1 = $this->speedTest('testPost', $size);
        $time2 = $this->speedTest('testPref', $size);
        $this->setData('Post', $size, $time1['time'], $part, $time1['memory'],'->');
        $this->setData('Pre', $size, $time2['time'], $part, $time2['memory'], '->');

        $part = $this->generatePart();
        $time2 = $this->speedTest('testPref', $size);
        $time1 = $this->speedTest('testPost', $size);
        $this->setData('Post', $size, $time1['time'], $part, $time1['memory'], '<-');
        $this->setData('Pre', $size, $time2['time'], $part, $time2['memory'], '<-');
    }

    public function testPref($size)
    {
        $testCounter = 0;
        for($i=0;$i<$size;$i++) {
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
        }
    }

    public function testPost($size)
    {
        $testCounter = 0;
        for($i=0;$i<$size;$i++) {
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
        }
    }
}