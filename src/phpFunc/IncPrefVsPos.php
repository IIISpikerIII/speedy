<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 01.08.16
 * Time: 21:41
 */
namespace speedyPack\phpFunc;

use speedyPack\interfaces\TestAbstract;
use speedyPack\interfaces\TestCore;
use speedyPack\interfaces\TestInterface;

class IncPrefVsPos extends TestAbstract implements TestInterface {

    public $name = 'Speedy ++i vs i++';
    public $valueTest = [100, 1000, 2000, 3000];
    public $qntTest = 5;
    public $viewers = [TestCore::VIEWER_TLIST, TestCore::VIEWER_TGROUP, TestCore::VIEWER_TAVG, TestCore::VIEWER_GBUBLE];
    protected $strategy = [['testPost', 'testPref'], ['testPref', 'testPost']];

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