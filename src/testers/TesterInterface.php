<?php

namespace speedy\testers;

use speedy\DTO\TestResultDTO;
use speedy\tests\interfaces\TestInterface;

interface TesterInterface
{
	public function run(TestInterface $object, string $method, int $size): TestResultDTO;
}