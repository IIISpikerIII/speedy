<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 10.08.16
 * Time: 20:04
 */

namespace speedy\viewers;

class TableListViewer extends ViewerAbstract
{
	public $view = '/viewer/tableList.php';

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public function prepareData(array $data): array
	{
		return $data;
	}
}