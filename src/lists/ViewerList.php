<?php


namespace speedy\lists;


class ViewerList
{
	public const VIEWER_TLIST = 'viewer:table_list';
	public const VIEWER_GBUBLE = 'viewer:graph_buble';
	public const VIEWER_TAVG = 'viewer:table_avg';
	public const VIEWER_TGROUP = 'viewer:table_group';

	public static function list()
	{
		return [
			self::VIEWER_TLIST,
			self::VIEWER_GBUBLE,
			self::VIEWER_TAVG,
			self::VIEWER_TGROUP,
		];
	}
}