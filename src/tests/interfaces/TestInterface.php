<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 10.08.16
 * Time: 19:56
 */

namespace speedy\tests\interfaces;

use speedy\testers\TesterInterface;
use speedy\viewers\ViewerInterface;

interface TestInterface
{
	public function run($onlyData = false);

	public function runByAllStrategies($size);

	public function addViewer(ViewerInterface $viewer);

	public function setViewers(array $viewers);

	public function setTester(TesterInterface $tester);

	public function setRepeat(int $repeats);
}