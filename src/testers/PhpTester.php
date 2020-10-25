<?php

namespace speedy\testers;

use speedy\DTO\TestResultDTO;
use speedy\tests\interfaces\TestInterface;

class PhpTester implements TesterInterface
{
	/**
	 * @param TestInterface $object
	 * @param string $method
	 * @param int $size
	 *
	 * @return TestResultDTO
	 */
	public function run(TestInterface $object, string $method, int $size): TestResultDTO
	{
		$memory = $this->getMemory();
		$time = $this->getTime();

		$object->$method($size);

		$time = $this->getTime($time);
		$memory = $this->getMemory($memory);

		return new TestResultDTO($memory, $time);
	}

	/**
	 * @param float|null $time
	 *
	 * @return float
	 */
	protected function getTime(float $time = null): float
	{
		return $time === null ? microtime(true) : microtime(true) - $time;
	}

	/**
	 * @param int|null $memory
	 *
	 * @return int
	 */
	protected function getMemory(int $memory = null): int
	{
		return $memory === null ? memory_get_usage() : memory_get_usage() - $memory;
	}
}