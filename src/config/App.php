<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 01.08.16
 * Time: 21:48
 */

namespace speedy\config;

use DI\Container;
use DI\ContainerBuilder;

class App
{
	protected static $container = null;

	/**
	 * @return Container
	 * @throws \Exception
	 */
	public static function makeContainer(): Container
	{
		if (self::$container === null) {
			$containerBuilder = new ContainerBuilder();
			$containerBuilder->addDefinitions(__DIR__ . '/config.php');
			$containerBuilder->addDefinitions(__DIR__ . '/di.php');
			$containerBuilder->useAutowiring(true);
			self::$container = $containerBuilder->build();
		}

		return self::$container;
	}
}