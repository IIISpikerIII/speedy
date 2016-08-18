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

class CompareTest extends TestAbstract implements TestInterface {

    public $name = 'Compare functions';
    public $valueTest = [100, 1000, 2000, 3000];
    public $qntTest = 5;
    public $viewers = [TestCore::VIEWER_TLIST, TestCore::VIEWER_TGROUP, TestCore::VIEWER_TAVG, TestCore::VIEWER_GBUBLE];
    public $functions = [];
    protected $strategy = [];

    public function __construct($functions){
        $this->functions = $functions;
        $this->strategy[] = array_keys($functions);
    }

    public function speedTest($method, $size)
    {
        $memory = $this->getMemory();
        $time = $this->getTime();
        $this->functions[$method]($size);
        $time = $this->getTime($time);
        $memory = $this->getMemory($memory);
        return ['memory' => $memory, 'time' => $time];
    }
}