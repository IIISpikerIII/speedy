<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 10.08.16
 * Time: 20:04
 */

namespace speedy\tests\interfaces;

use speedy\DTO\TestDataDTO;
use speedy\viewers\ViewerInterface;
use speedy\DTO\TestResultDTO;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class TestAbstract extends TestCore implements TestInterface
{
	/** @var ViewerInterface[]  */
	protected $viewers = [];
	protected $functions = [];

	public function preparePart(int $size)
	{
	}

	/**
	 * @param ViewerInterface $viewer
	 */
	public function addViewer(ViewerInterface $viewer): void
	{
		$this->viewers[] = $viewer;
	}

	/**
	 * @param ViewerInterface[] $viewers
	 */
	public function setViewers(array $viewers)
	{
		$this->viewers = $viewers;
	}

	public function setRepeat(int $repeats)
	{
		$this->repeatTest = $repeats;
	}

	/**
	 * @param bool $onlyData
	 *
	 * @return TestDataDTO[]|string
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	public function run($onlyData = false)
	{
		ini_set("memory_limit", "512M");
		$this->initDataTable();
		$this->clearData();
		foreach ($this->volumesTest as $size) {
			$count = 1;
			$this->preparePart($size);
			while ($count <= $this->repeatTest) {
				$this->runByAllStrategies($size);
				$count++;
			}
		}

		return $onlyData ? $this->getData() : $this->renderResult();
	}

	/**
	 * @return string
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	public function renderResult(): string
	{
		$title = $this->name;
		$data = $this->getData();
		$views = [];
		foreach ($this->viewers as $viewer) {
			$views[] = $viewer->run($data);
		}

		$this->clearData();

		return $this->twig->render($this->view, compact('views', 'title'));
	}

	/**
	 * @param $size
	 */
	public function runByAllStrategies($size): void
	{
		if (count($this->strategy) === 0) {
			return;
		}

		//variable set for memory
		$part = $this->generatePart();
		$comment = $this->generateCommentTest($this->strategy[0]);
		foreach ($this->strategy[0] as $test) {
			$testResult = $this->speedTest($test, $size);
			$this->setData(self::DUMMY_NAME, $size, $testResult->getTime(), $part, $testResult->getMemory(), $comment, self::DUMMY_NAME);
		}

		foreach ($this->strategy as $strategy) {
			$part = $this->generatePart();
			$comment = $this->generateCommentTest($strategy);
			foreach ($strategy as $test) {
				$testResult = $this->speedTest($test, $size);
				$name = $this->generateNameTest($test);
				$this->setData($name, $size, $testResult->getTime(), $part, $testResult->getMemory(), $comment);
			}
		}
	}

	protected function generateNameTest($funcName)
	{
		$name = array_search($funcName, $this->functions, true);

		return $name !== false ? $name : $funcName;
	}

	protected function generateCommentTest(Array $strategy)
	{
		$comment = [];
		foreach ($strategy as $func) {
			$comment[] = $this->generateNameTest($func);
		}

		return implode('-', $comment);
	}

	/**
	 * @param string $method
	 * @param int $size
	 *
	 * @return TestResultDTO
	 */
	protected function speedTest(string $method, int $size): TestResultDTO
	{
		return $this->tester->run($this, $method, $size);
	}
}