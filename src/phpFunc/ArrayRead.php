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

class ArrayRead extends TestAbstract
{
    public $name = 'Speedy For vs While vs Foreach';
    public $valueTest = [10000, 50000, 100000];
    public $qntTest = 5;
    public $viewers = [TestCore::VIEWER_TLIST, TestCore::VIEWER_TGROUP, TestCore::VIEWER_TAVG, TestCore::VIEWER_GBUBLE];
    public $functions = ['For' => 'testFor', 'While' => 'testWhile', 'Foreach' => 'testForeach'];
    protected $strategy = [['testFor', 'testWhile', 'testForeach'], ['testWhile', 'testFor', 'testForeach'], ['testForeach', 'testFor', 'testWhile'],];
    private $testArray = [];

    public function initPart($size)
    {
        $this->testArray = ArrayHelper::getRndArray($size,10);
    }

    public function testFor($size)
    {
        $testCounter = 0;
        $arraySize = sizeof($this->testArray);
        for($i=1;$i<=$arraySize;$i++) {
            $test = $this->testArray[$i.'_'.$i];
        }
    }

    public function testWhile($size)
    {
        $testCounter = 0;
        $arraySize = sizeof($this->testArray);
        while($testCounter < $arraySize) {
            $testCounter++;
            $test = $this->testArray[$testCounter.'_'.$testCounter];
        }
    }

    public function testForeach($size)
    {
        $testCounter = 0;
        foreach($this->testArray as $value) {
            $test = $value;
        }
    }
}