<?php

namespace speedy\config;

use PDO;

class Database
{
	/** @var array */
	private $params;

	/**
	 * database constructor.
	 *
	 * @param array $params
	 */
	public function __construct(array $params)
	{
		$this->params = $params;
	}

	/**
	 * @param string $name
	 * @param null $defaultValue
	 *
	 * @return mixed|null
	 */
	private function getParam(string $name, $defaultValue = null)
	{
		return $this->params[$name] ?? $defaultValue;
	}

	/**
	 * @return PDO
	 */
	public function getConnection(): PDO
	{
		$dbName = $this->getParam('name');

		return new PDO('sqlite:' . $dbName);
	}
}