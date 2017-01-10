<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 01.08.16
 * Time: 21:41
 */
namespace speedyPack\phpFunc;

use speedyPack\helpers\ArrayHelper;
use speedyPack\interfaces\TestAbstract;
use speedyPack\interfaces\TestCore;
use speedyPack\interfaces\TestInterface;

class SizeofVsCount extends TestAbstract implements TestInterface
{
    public $name = 'Speedy Sizeof vs Count';
    public $valueTest = [10000, 100000, 500000, 1000000];
    public $qntTest = 5;
    public $viewers = [TestCore::VIEWER_TLIST, TestCore::VIEWER_TGROUP, TestCore::VIEWER_TAVG, TestCore::VIEWER_GBUBLE];
    public $functions = ['count' => 'testCount', 'sizeof' => 'testSizeof'];
    protected $strategy = [['testCount', 'testSizeof'], ['testSizeof', 'testCount']];
    private $testArray = [];

    public function initPart($size)
    {
        $this->testArray = ArrayHelper::getRndArray($size,10);
    }

    public function testCount($size)
    {
        $array =  $this->testArray;
        for($i=0;$i<10000;$i++) {
            count($array); count($array); count($array); count($array); count($array);
            count($array); count($array); count($array); count($array); count($array);
            count($array); count($array); count($array); count($array); count($array);
        }
    }

    public function testSizeof($size)
    {
        $array =  $this->testArray;
        for($i=0;$i<10000;$i++) {
            sizeof($array); sizeof($array); sizeof($array); sizeof($array); sizeof($array);
            sizeof($array); sizeof($array); sizeof($array); sizeof($array); sizeof($array);
            sizeof($array); sizeof($array); sizeof($array); sizeof($array); sizeof($array);
        }
    }
}