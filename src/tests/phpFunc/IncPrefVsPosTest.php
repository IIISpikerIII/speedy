<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 01.08.16
 * Time: 21:41
 */

namespace speedy\tests\phpFunc;

use speedy\tests\interfaces\TestAbstract;

class IncPrefVsPosTest extends TestAbstract
{
	public $name = 'Speedy ++i vs i++';
	public $volumesTest = [100, 1000, 2000, 3000];
	public $functions = ['postInc' => 'testPost', 'prefInc' => 'testPref'];
	protected $strategy = [['testPost', 'testPref'], ['testPref', 'testPost']];

	public function testPref($size)
	{
		$testCounter = 0;
		for ($i = 0; $i < $size; $i++) {
			++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
			++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
			++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
			++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
		}
	}

	public function testPost($size)
	{
		$testCounter = 0;
		for ($i = 0; $i < $size; $i++) {
			$testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
			$testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
			$testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
			$testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
		}
	}
}