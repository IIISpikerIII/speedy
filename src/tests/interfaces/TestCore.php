<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 10.08.16
 * Time: 20:04
 */

namespace speedy\tests\interfaces;

use speedy\DTO\TestDataDTO;
use speedy\repositories\DataRepository;
use speedy\testers\TesterInterface;
use Twig\Environment;

abstract class TestCore
{
	const DUMMY_NAME = 'dummy';

	private $part = 0;

	/** @var DataRepository */
	protected $dataRepository;

	/**  @var Environment  */
	protected $twig;

	/** @var TesterInterface */
	protected $tester;

	protected $strategy = [];

	protected $repeatTest = 5;
	public $volumesTest = [100, 1000, 2000, 3000, 5000];
	public $name = 'Speedy test';
	public $view = 'test_result.php';

	public function __construct(DataRepository $dataRepository, Environment $twig)
	{
		$this->dataRepository = $dataRepository;
		$this->twig = $twig;
		$this->initDataTable();
	}

	abstract function renderResult(): string;

	abstract function run($onlyData = false);

	protected function initDataTable()
	{
		$this->dataRepository->initTable();
	}

	/**
	 * @param TesterInterface $tester
	 */
	public function setTester(TesterInterface $tester): void
	{
		$this->tester = $tester;
	}

	/**
	 * @param string $name
	 * @param int $size
	 * @param float $time
	 * @param int $part
	 * @param int $memory
	 * @param string $comment
	 * @param string $testName
	 *
	 * @return bool
	 */
	protected function setData(string $name, int $size, float $time, int $part, int $memory, string $comment, string $testName = __CLASS__): bool
	{
		return $this->dataRepository->setData(new TestDataDTO($testName, $name, $size, $time, $part, $memory, $comment));
	}

	/**
	 * @param string $testName
	 *
	 * @return TestDataDTO[]
	 */
	protected function getData(string $testName = __CLASS__): array
	{
		return $this->dataRepository->getDataByName($testName);
	}

	/**
	 * @param string $testName
	 */
	protected function clearData(string $testName = __CLASS__): void
	{
		$this->dataRepository->clearDataByName($testName, self::DUMMY_NAME);
	}

	/**
	 * @return int
	 */
	protected function generatePart(): int
	{
		return ++$this->part;
	}

	/**
	 * @param int $part
	 */
	protected function setPart(int $part): void
	{
		$this->part = $part;
	}
}