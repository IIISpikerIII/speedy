<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 01.08.16
 * Time: 21:41
 */

namespace speedy\tests\phpFunc;

use speedy\tests\interfaces\TestAbstract;

class CompareTest extends TestAbstract
{
	protected $funcPrefix = 'user_';
	public $name = 'Compare functions';
	public $volumesTest = [100, 1000, 2000, 3000];

	public function setupFunctions(array $functions = [])
	{
		foreach ($functions as $funcName => $function) {
			if (is_callable($function)) {
				$this->functions[$this->funcPrefix . $funcName] = $function;
			}
		}
		
		$this->generateStrategy();
	}

	protected function generateStrategy()
	{
		$strategy = [];
		foreach ($this->functions as $funcName => $function) {
			$strategy[] = $funcName;
		}

		$this->strategy[] = $strategy;
	}

	public function __call($name, $arguments)
	{
		if(isset($this->functions[$name])) {
			return $this->functions[$name](array_shift($arguments));
		}
	}
}