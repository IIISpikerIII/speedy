<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 17.08.16
 * Time: 20:39
 */

namespace speedy;

use DI\DependencyException;
use DI\NotFoundException;
use RuntimeException;
use speedy\config\App;
use speedy\DTO\TestDataDTO;
use speedy\lists\TesterList;
use speedy\lists\TestList;
use speedy\lists\ViewerList;
use speedy\testers\TesterInterface;
use speedy\tests\phpFunc\CompareTest;
use speedy\tests\interfaces\TestInterface;
use speedy\viewers\ViewerInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Speedy
{
	/** @var \DI\Container */
	private $container;

	/** @var TesterInterface */
	private $tester;

	/** @var array */
	private $viewers;

	/** @var int */
	private $repeatTest = 0;

	/**
	 * Speedy constructor.
	 *
	 * @param string $tester
	 * @param array $viewers
	 *
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	public function __construct(string $tester = TesterList::TESTER_PHP, array $viewers = [])
	{
		$viewersName = count($viewers) > 0 ? $viewers : ViewerList::list();
		$this->container = App::makeContainer();

		$this->setTester($tester);
		$this->setViewers($viewersName);
	}

	/**
	 * @param string $tester
	 *
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	public function setTester(string $tester): void
	{
		$this->tester = $this->buildTester($tester);
	}

	/**
	 * @param string[] $viewers
	 *
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	public function setViewers(array $viewers): void
	{
		$this->viewers = $this->buildViewers($viewers);
	}

	/**
	 * @param int $repeatTest
	 */
	public function setRepeatTest(int $repeatTest): void
	{
		$this->repeatTest = $repeatTest;
	}

	/**
	 * @param string $testName
	 * @param array $viewers
	 * @param bool $onlyData
	 *
	 * @return TestDataDTO[]|string|null
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	public function runTestByName(string $testName, array $viewers = [], bool $onlyData = false)
	{
		$test = $this->buildTest($testName);
		$test->setTester($this->tester);

		if ($this->repeatTest > 0) {
			$test->setRepeat($this->repeatTest);
		}

		$viewers = count($viewers) > 0 ? $this->buildViewers($viewers) : $this->viewers;
		$test->setViewers($viewers);

		return $test->run($onlyData);
	}

	/**
	 * @param ViewerInterface[] $viewers
	 *
	 * @return array
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	protected function buildViewers(array $viewers): array
	{
		$viewersList = [];
		foreach ($viewers as $viewerName) {

			if (!in_array($viewerName, ViewerList::list(), true)) {
				throw new RuntimeException('Viewer ' . $viewerName . ' not found');
			}

			$viewersList[] = $this->container->get($viewerName);
		}

		return $viewersList;
	}

	/**
	 * @param string $tester
	 *
	 * @return TesterInterface
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	protected function buildTester(string $tester): TesterInterface
	{
		if (!in_array($tester, TesterList::list(), true)) {
			throw new RuntimeException('Tester not found');
		}

		return $this->container->get($tester);
	}

	/**
	 * @param string $test
	 *
	 * @return TestInterface
	 * @throws DependencyException
	 * @throws NotFoundException
	 */
	protected function buildTest(string $test): TestInterface
	{
		if (!in_array($test, TestList::list(), true)) {
			throw new RuntimeException('Test ' . $test . ' not found');
		}

		return $this->container->get($test);
	}

	/**
	 * @param $test
	 * @param array $params
	 * @param bool $onlyData
	 *
	 * @return mixed
	 * @throws DependencyException
	 * @throws NotFoundException
	 *
	 * @TODO it is legacy need refacoring
	 */
	public static function test($test, $params = [], $onlyData = false)
	{
		$container = App::makeContainer();
		/** @var TestInterface $test */
		$test = $container->get($test);

		foreach ($params as $key => $value) {

			if ($key === 'tester') {
				$tester = self::getTester($value);
				$test->setTester($tester);
				continue;
			}

			if (isset($test->$key)) {
				$test->$key = $value;
			}
		}

		$viewers = isset($params['viewers']) && is_array($params['viewers']) ? $params['viewers'] : ViewerList::list();
		foreach ($viewers as $viewerName) {
			$test->addViewer($container->get($viewerName));
		}

		$tester = self::getTester(TesterList::TESTER_PHP);
		$test->setTester($tester);

		return $test->run($onlyData);
	}

	/**
	 * @param array $func
	 * @param array $params
	 * @param bool $onlyData
	 *
	 * @return TestDataDTO[]|string
	 * @throws DependencyException
	 * @throws NotFoundException
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 *
	 * @TODO it is legacy need refacoring
	 */
	public static function compare($func = [], $params = [], $onlyData = false)
	{
		$container = App::makeContainer();
		/** @var CompareTest $test */
		$test = $container->get(CompareTest::class);
		$test->setupFunctions($func);

		foreach ($params as $key => $value) {

			if ($key == 'tester') {
				$tester = self::getTester($value);
				$test->setTester($tester);
				continue;
			}

			if (isset($test->$key)) {
				$test->$key = $value;
			}
		}

		$viewers = isset($params['viewers']) && is_array($params['viewers']) ? $params['viewers'] : ViewerList::list();
		foreach ($viewers as $viewerName) {
			$test->addViewer($container->get($viewerName));
		}

		$tester = self::getTester(TesterList::TESTER_PHP);
		$test->setTester($tester);

		return $test->run($onlyData);
	}

	/**
	 * @param $testerParams
	 *
	 * @return mixed
	 * @throws DependencyException
	 * @throws NotFoundException
	 *
	 * @TODO it is legacy need refacoring
	 */
	private static function getTester($testerParams)
	{
		$container = App::makeContainer();
		if (!is_array($testerParams)) {
			return $container->get($testerParams);
		}

		$tester = $container->get($testerParams['name']);

		foreach ($testerParams as $key => $value) {
			if (isset($tester->$key)) {
				$tester->$key = $value;
			}
		}

		return $tester;
	}

} 