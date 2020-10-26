<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 01.08.16
 * Time: 21:41
 */

namespace speedy\tests\phpFunc;

use speedy\helpers\ArrayHelper;
use speedy\tests\interfaces\TestAbstract;

class SizeofVsCountTest extends TestAbstract
{
	public $name = 'Speedy Sizeof vs Count';
	public $volumesTest = [10000, 100000, 500000, 1000000];
	public $functions = ['count' => 'testCount', 'sizeof' => 'testSizeof'];
	protected $strategy = [['testCount', 'testSizeof'], ['testSizeof', 'testCount']];
	private $testArray = [];

	public function preparePart(int $size)
	{
		$this->testArray = ArrayHelper::getRndArray($size, 10);
	}

	public function testCount($size)
	{
		$array = $this->testArray;
		for ($i = 0; $i < 10000; $i++) {
			count($array); count($array); count($array); count($array); count($array);
			count($array); count($array); count($array); count($array); count($array);
			count($array); count($array); count($array); count($array); count($array);
		}
	}

	public function testSizeof($size)
	{
		$array = $this->testArray;
		for ($i = 0; $i < 10000; $i++) {
			sizeof($array); sizeof($array); sizeof($array); sizeof($array); sizeof($array);
			sizeof($array); sizeof($array); sizeof($array); sizeof($array); sizeof($array);
			sizeof($array); sizeof($array); sizeof($array); sizeof($array); sizeof($array);
		}
	}
}