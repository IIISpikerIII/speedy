<?php

namespace speedy\lists;

class TestList
{
	public const PHP_INC_PREF_POST = 'php:inc_pref:inc_post';
	public const PHP_ARR_READ = 'php:array:read';
	public const PHP_ARR_SORT = 'php:array:sort';
	public const PHP_SOF_VS_COUNT = 'php:array:size';

	public static function list()
	{
		return [
			self::PHP_INC_PREF_POST,
			self::PHP_ARR_READ,
			self::PHP_ARR_SORT,
			self::PHP_SOF_VS_COUNT,
		];
	}
}