<?php

namespace speedy\lists;

class TesterList
{
	public const TESTER_PHP = 'tester:php';
	public const TESTER_XHPROF = 'tester:xhprof';

	public static function list()
	{
		return [
			self::TESTER_PHP,
			self::TESTER_XHPROF,
		];
	}
}