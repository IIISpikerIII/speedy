<?php

namespace speedy\DTO;

class TestResultDTO
{
	/** @var int */
	private $memory;

	/** @var float */
	private $time;

	public function __construct(int $memory, float $time)
	{
		$this->memory = $memory;
		$this->time = $time;
	}

	/**
	 * @return int
	 */
	public function getMemory(): int
	{
		return $this->memory;
	}

	/**
	 * @return float
	 */
	public function getTime(): float
	{
		return $this->time;
	}
}