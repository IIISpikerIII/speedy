<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 01.08.16
 * Time: 21:41
 */

namespace speedy\tests\phpFunc;

use speedy\helpers\ArrayHelper;
use speedy\tests\interfaces\TestAbstract;

class ArraySortTest extends TestAbstract
{
	public $name = 'Speedy Bubble, Select, Insertion, Quick, Heap';
	public $volumesTest = [100, 500];
	public $functions = ['Bubble' => 'testBubble', 'Select' => 'testSelect', 'Insertion' => 'testInsertion', 'Quick' => 'testQuick', 'Heap' => 'testHeap'];
	protected $strategy = [['testHeap', 'testBubble', 'testSelect', 'testInsertion', 'testQuick'], ['testQuick', 'testInsertion', 'testSelect', 'testBubble', 'testHeap'],];
	private $testArray = [];

	/**
	 * @param int $size
	 */
	public function preparePart(int $size)
	{
		$this->testArray = ArrayHelper::getRndArrayNum($size);
	}

	/**
	 * Bubble sort О(n2)
	 *
	 * @param $size
	 */
	public function testBubble($size)
	{
		$arr = $this->testArray;

		$size = count($arr) - 1;
		for ($i = $size; $i >= 0; $i--) {
			for ($j = 0; $j <= ($i - 1); $j++) {
				if ($arr[$j] > $arr[$j + 1]) {
					$k = $arr[$j];
					$arr[$j] = $arr[$j + 1];
					$arr[$j + 1] = $k;
				}
			}
		}
	}

	/**
	 * Select sort О(n2)
	 *
	 * @param $size
	 */
	public function testSelect($size)
	{
		$arr = $this->testArray;
		$size = count($arr);

		for ($i = 0; $i < $size - 1; $i++) {
			$min = $i;

			for ($j = $i + 1; $j < $size; $j++) {
				if ($arr[$j] < $arr[$min]) {
					$min = $j;
				}
			}

			$temp = $arr[$i];
			$arr[$i] = $arr[$min];
			$arr[$min] = $temp;
		}
	}

	/**
	 * Insertion sort О(n2)
	 *
	 * @param $size
	 */
	public function testInsertion($size)
	{
		$a = $this->testArray;
		for ($i = 1; $i < count($a); $i++) {
			$x = $a[$i];
			for ($j = $i - 1; $j >= 0 && $a[$j] > $x; $j--) {
				$a[$j + 1] = $a[$j];
			}
			// на оставшееся после сдвига место, ставим $a[$i]
			$a[$j + 1] = $x;
		}
	}

	/**
	 * Shake sort
	 *
	 * @param $size
	 */
	public function testShake($size)
	{
		$a = $this->testArray;
		$n = count($a);
		$left = 0;
		$right = $n - 1;
		do {
			for ($i = $left; $i < $right; $i++) {
				if ($a[$i] > $a[$i + 1]) {
					list($a[$i], $a[$i + 1]) = [$a[$i + 1], $a[$i]];
				}
			}
			$right -= 1;
			for ($i = $right; $i > $left; $i--) {
				if ($a[$i] < $a[$i - 1]) {
					list($a[$i], $a[$i - 1]) = [$a[$i - 1], $a[$i]];
				}
			}
			$left += 1;
		} while ($left <= $right);
	}

	/**
	 * Quick sort O(n*log n)
	 *
	 * @param $size
	 */
	public function testQuick($size)
	{
		$arr = $this->testArray;
		$this->quicksort($arr);
	}

	protected function quicksort(&$array, $l = 0, $r = 0)
	{
		if ($r === 0) {
			$r = count($array) - 1;
		}
		$i = $l;
		$j = $r;
		$x = $array[($l + $r) / 2];
		do {
			while ($array[$i] < $x) {
				$i++;
			}
			while ($array[$j] > $x) {
				$j--;
			}
			if ($i <= $j) {
				if ($array[$i] > $array[$j]) {
					list($array[$i], $array[$j]) = [$array[$j], $array[$i]];
				}
				$i++;
				$j--;
			}
		} while ($i <= $j);
		if ($i < $r) {
			$this->quicksort($array, $i, $r);
		}
		if ($j > $l) {
			$this->quicksort($array, $l, $j);
		}
	}

	public function testHeap($size)
	{
		$array = $this->testArray;
		$n = count($array);
		for ($i = ($n / 2) - 1; $i >= 0; $i--) {             // построение пирамиды
			$this->sink($array, $i, $n - 1);
		}
		for ($i = $n - 1; $i > 0; $i--) {
			$t = $array[$i];                                // меняем первый элемент в пирамиде на последний
			$array[$i] = $array[0];
			$array[0] = $t;
			$this->sink($array, 0, $i - 1);                  // восстанавливаем пирамидальность
		}
	}

	protected function sink(array &$array, $k, $n)
	{
		$e = $array[$k];
		while ($k <= $n / 2) {                               // цикл выполняется пока есть потомки
			$j = $k * 2;                                    // индекс первого потомка
			if ($j < $n && $array[$j] < $array[$j + 1]) {    // выбор наибольшего потомка
				$j++;
			}
			if ($e >= $array[$j]) {
				break;
			}
			$array[$k] = $array[$j];                        // двигаем потомка на уровень выше
			$k = $j;
		}
	}
}