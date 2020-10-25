<?php

namespace speedy\viewers;

use speedy\DTO\TestDataDTO;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TableAvgViewer extends ViewerAbstract
{
	public $view = '/viewer/tableAvg.php';

	/**
	 * @param TestDataDTO[] $data
	 *
	 * @return array
	 */
	protected function groupData(array $data): array
	{
		$groupData = [];
		$groupNames = [];
		$groupStat = [];

		foreach ($data as $test) {
			$size = $test->getSize();
			$part = $test->getPart();
			$time = $test->getTime();
			$name = $test->getName();

			if (!isset($groupData[$size])) {
				$groupData[$size][$part] = [];
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

			$groupData[$size][$part][$name] = $test;

			if (!in_array($name, $groupNames, true)) {
				$groupNames[] = $name;
			}
		}

		return ['names' => $groupNames, 'data' => $groupData, 'groupStat' => $groupStat];
	}

	/**
	 * @param TestDataDTO[] $data
	 *
	 * @return array
	 */
	public function prepareData(array $data): array
	{
		$groupData = $this->groupData($data);

		$avgArray = [];
		foreach ($groupData['data'] as $size => $parts) {

			if (!isset($avgArray[$size])) {
				$avgArray[$size] = [];
			}

			foreach ($parts as $numPart => $part) {
				$timeWinn = false;
				$nameWinn = [];
				$percentWinn = false;

				$groupData['groupStat'][$size]['avgPercent'] = [];

				/** @var TestDataDTO $test */
				foreach ($part as $nameTest => $test) {

					$time = $test->getTime();
					$name = $test->getName();
					$percent = (($groupData['groupStat'][$size][$numPart]['maxTime'] - $time) / ($groupData['groupStat'][$size][$numPart]['maxTime'])) * 100;

					if (!isset($avgArray[$size][$name])) {
						$avgArray[$size][$name] = ['count' => 0, 'percent' => []];
					}

					if ($timeWinn === $time) {
						$nameWinn[] = $name;
						$percentWinn = $percent;
						continue;
					}

					if ($timeWinn === false || $timeWinn > $time) {
						$nameWinn = [$name];
						$timeWinn = $time;
						$percentWinn = $percent;
					}
				}

				foreach ($nameWinn as $nameItem) {
					++$avgArray[$size][$nameItem]['count'];
					//accumulate winn percents
					$avgArray[$size][$nameItem]['percent'][] = $percentWinn;
				}
			}

			//calc avg percent
			foreach ($avgArray[$size] as &$partStat) {
				$percents = $partStat['percent'];
				$partStat['percent'] = count($percents) > 0 ? array_sum($percents) / count($percents) : 0;
			}
		}

		return ['data' => $avgArray, 'names' => $groupData['names']];
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

		return $this->twig->render($this->view, ['data' => $data['data'], 'names' => $data['names']]);
	}
}