<?php

namespace speedy\viewers;

use Ghunti\HighchartsPHP\Highchart;
use speedy\DTO\TestDataDTO;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GraphBubleViewer extends ViewerAbstract
{
	public $view = '/viewer/graphBuble.php';

	/**
	 * @param TestDataDTO[] $data
	 *
	 * @return array
	 */
	public function prepareData(array $data): array
	{
		$dataArr = [];
		$groupNames = [];

		foreach ($data as $row) {

			$name = $row->getName();
			if (!isset($dataArr[$name])) {
				$dataArr[$name] = [
					'name' => $name,
					'data' => [],
				];
			}

			if (!in_array($name, $groupNames, true)) {
				$groupNames[] = $name;
			}

			$dataArr[$name]['data'][] = [$row->getTime(), $row->getSize()];
		}

		return $dataArr;
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

		if (count($data) === 0) {
			return '';
		}

		$chart = new Highchart();
		$chart->title = ['text' => ''];
		$chart->chart = [
			'renderTo' => 'container',
			'type' => 'scatter',
			'zoomType' => 'xy',
		];
		$chart->plotOptions->scatter->marker->radius = 8;
		$chart->plotOptions->scatter->marker->states->hover->enabled = 1;
		$chart->plotOptions->scatter->marker->states->hover->lineColor = "rgb(100,100,100)";
		$chart->plotOptions->scatter->states->hover->marker->enabled = false;
		$chart->series = array_values($data);

		$chart->printScripts();
		$chart = '<script>' . $chart->render("chart") . '</script>';

		return $this->twig->render($this->view, compact('chart'));
	}
}