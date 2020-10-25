<?php
namespace speedy\viewers;

use speedy\DTO\TestDataDTO;

interface ViewerInterface
{
	/**
	 * @param array $data
	 *
	 * @return array
	 */
    public function prepareData(array $data): array;

	/**
	 * @param TestDataDTO[] $data
	 *
	 * @return string
	 */
    public function run(array $data): string;
}