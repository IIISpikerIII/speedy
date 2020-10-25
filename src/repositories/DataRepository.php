<?php

namespace speedy\repositories;

use speedy\config\Database;
use speedy\DTO\TestDataDTO;

class DataRepository
{
	/** @var \PDO */
	private $connection;

	public function __construct(Database $db)
	{
		$this->connection = $db->getConnection();
	}

	public function initTable(): void
	{
		$this->connection->exec("CREATE TABLE IF NOT EXISTS data (test_name, name, size, time, part, memory, comment)");
	}

	/**
	 * @param TestDataDTO $data
	 *
	 * @return bool
	 */
	public function setData(TestDataDTO $data): bool
	{
		$command = $this->connection->prepare("INSERT INTO data(test_name, name, size, time, part, memory, comment) VALUES (?, ?, ?, ?, ?, ?, ?)");
		$params = [
			$data->getTestName(),
			$data->getName(),
			$data->getSize(),
			$data->getTime(),
			$data->getPart(),
			$data->getMemory(),
			$data->getComment(),
		];

		return $command->execute($params);
	}

	/**
	 * @param string $name
	 *
	 * @return TestDataDTO[]
	 */
	public function getDataByName(string $name): array
	{
		$command = $this->connection->prepare('select * from data where test_name = ?');
		$command->setFetchMode(\PDO::FETCH_ASSOC);
		$command->execute([$name]);

		return $this->hydrateDTO($command->fetchAll());
	}

	/**
	 * @param array $dataItems
	 *
	 * @return TestDataDTO[]
	 */
	protected function hydrateDTO(array $dataItems): array
	{
		$data = [];
		foreach ($dataItems as $dataItem) {
			$testName = $dataItem['test_name'];
			$name = $dataItem['name'];
			$size = $dataItem['size'];
			$time = $dataItem['time'];
			$part = $dataItem['part'];
			$memory = $dataItem['memory'];
			$comment = $dataItem['comment'];
			$data[] = new TestDataDTO($testName, $name, $size, $time, $part, $memory, $comment);
		}

		return $data;
	}

	/**
	 * @param string $name
	 * @param string|null $dummy
	 *
	 * @return bool
	 */
	public function clearDataByName(string $name, string $dummy = null): bool
	{
		$command = $this->connection->prepare("delete from data where test_name IN (?, ?)");

		return $command->execute([$name, $dummy]);
	}
}