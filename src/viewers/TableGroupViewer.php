<?php

namespace speedy\viewers;

use speedy\DTO\TestDataDTO;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TableGroupViewer extends ViewerAbstract
{
	public $view = '/viewer/tableGroup.php';

	/**
	 * @param TestDataDTO[] $data
	 *
	 * @return array
	 */
	public function prepareData(array $data): array
	{
		$groupNames = [];
		$groupStat = [];
		$groupTest = [];

		foreach ($data as $test) {
			$size = $test->getSize();
			$part = $test->getPart();
			$time = $test->getTime();
			$name = $test->getName();

			if (!isset($groupTest[$size])) {
				$groupTest[$size][$part] = [];
				$groupStat[$size][$part] = [
					'maxTime' => false,
					'minTime' => false,
				];
			}

			$maxTime = &$groupStat[$size][$part]['maxTime'];
			$minTime = &$groupStat[$size][$part]['minTime'];

			if ($maxTime === false || $maxTime < $time) {
				$maxTime = $time;
			}

			if ($minTime === false || $minTime > $time) {
				$minTime = $time;
			}

			if (!in_array($name, $groupNames, true)) {
				$groupNames[] = $name;
			}

			$groupTest[$size][$part][$name] = $test;
		}

		return ['names' => $groupNames, 'groupTest' => $groupTest, 'groupStat' => $groupStat];
	}

	/**
	 * @param TestDataDTO[] $data
	 *
	 * @return string
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	public function run(array $data): string
	{
		$data = $this->prepareData($data);

		return $this->twig->render($this->view, ['data' => $data['groupTest'], 'names' => $data['names'], 'stat' => $data['groupStat']]);
	}
}