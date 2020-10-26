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

class ArrayReadTest extends TestAbstract
{
	public $name = 'Speedy For vs While vs Foreach';
	public $volumesTest = [10000, 50000, 100000];
	public $functions = ['For' => 'testFor', 'While' => 'testWhile', 'Foreach' => 'testForeach'];
	protected $strategy = [['testFor', 'testWhile', 'testForeach'], ['testWhile', 'testFor', 'testForeach'], ['testForeach', 'testFor', 'testWhile'],];
	private $testArray = [];

	/**
	 * @param int $size
	 *
	 * @throws \Exception
	 */
	public function preparePart(int $size)
	{
		$this->testArray = ArrayHelper::getRndArray($size, 10);
	}

	public function testFor($size)
	{
		$testCounter = 0;
		$arraySize = sizeof($this->testArray);
		for ($i = 1; $i <= $arraySize; $i++) {
			$test = $this->testArray[$i . '_' . $i];
		}
	}

	public function testWhile($size)
	{
		$testCounter = 0;
		$arraySize = sizeof($this->testArray);
		while ($testCounter < $arraySize) {
			$testCounter++;
			$test = $this->testArray[$testCounter . '_' . $testCounter];
		}
	}

	public function testForeach($size)
	{
		$testCounter = 0;
		foreach ($this->testArray as $value) {
			$test = $value;
		}
	}
}