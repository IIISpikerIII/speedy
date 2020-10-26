<?php

namespace speedy\DTO;

class TestDataDTO
{
	/** @var string */
	protected $testName;
	/** @var string */
	protected $name;
	/** @var int */
	protected $size;
	/** @var float */
	protected $time;
	/** @var int */
	protected $part;
	/** @var int */
	protected $memory;
	/** @var string */
	protected $comment;

	public function __construct(string $testName, string $name, int $size, float $time, int $part = null, int $memory = null, string $comment = null)
	{
		$this->testName = $testName;
		$this->name = $name;
		$this->size = $size;
		$this->time = $time;
		$this->part = $part;
		$this->memory = $memory;
		$this->comment = $comment;
	}

	/**
	 * @return string
	 */
	public function getTestName(): string
	{
		return $this->testName;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return int
	 */
	public function getSize(): int
	{
		return $this->size;
	}

	/**
	 * @return float
	 */
	public function getTime(): float
	{
		return $this->time;
	}

	/**
	 * @return int
	 */
	public function getPart(): int
	{
		return $this->part;
	}

	/**
	 * @return int
	 */
	public function getMemory(): int
	{
		return $this->memory;
	}

	/**
	 * @return string
	 */
	public function getComment(): string
	{
		return $this->comment;
	}
}