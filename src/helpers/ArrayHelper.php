<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 01.08.16
 * Time: 22:57
 */

namespace speedy\helpers;

class ArrayHelper
{

	/**
	 * @param int $size
	 * @param int $itemSize
	 *
	 * @return array
	 * @throws \Exception
	 */
	public static function getRndArray(int $size = 10, int $itemSize = 6): array
	{
		$resultArray = [];
		$symbol = 'ABCDEFGHIJKLMNOPQRSTUVWXYZАzyxwvutsrqponmlkjihgfedcbaаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя123465790';
		$length = strlen($symbol);
		$pos = 0;

		while ($pos <= $size) {
			$posItem = 0;
			$pos++;
			$item = '';

			while ($posItem <= $itemSize) {
				$posItem++;
				$position = random_int(0, $length - 1);
				$item .= $symbol[$position];
			}

			$resultArray[$pos . '_' . $pos] = $item;
		}

		return $resultArray;
	}



	public static function getRndArrayNum(int $size = 10, int $itemMaxSize = 999999)
	{
		$resultArray = [];
		$pos = 0;

		while ($pos <= $size) {
			$pos++;
			$item = random_int(0, $itemMaxSize);
			$resultArray[] = $item;
		}

		return $resultArray;
	}
}