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
use speedy\config\App;
use speedy\DTO\TestDataDTO;
use speedy\lists\TesterList;
use speedy\lists\TestList;
use speedy\lists\ViewerList;
use speedy\tests\phpFunc\CompareTest;
use speedy\tests\interfaces\TestInterface;
use speedy\viewers\ViewerInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Speedy
{

	/** @var \DI\Container  */
	private $container;

	public function __construct()
	{
		$this->container = App::makeContainer();
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
		if (in_array($testName, TestList::list(), true)) {

			/** @var TestInterface $test */
			$test = $this->container->get($testName);
			$test->setTester($this->container->get(TesterList::TESTER_PHP));

			$viewers = count($viewers) > 0 ? $viewers : ViewerList::list();
			$test->setViewers($this->buildViewers($viewers));

			return $test->run($onlyData);
		}

		return null;
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
			$viewersList[] = $this->container->get($viewerName);
		}

		return $viewersList;
	}

	/**
	 * @param $test
	 * @param array $params
	 * @param bool $onlyData
	 *
	 * @return mixed
	 * @throws DependencyException
	 * @throws NotFoundException
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