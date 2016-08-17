<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

defined('BASE_PATH') or define('BASE_PATH',__DIR__.'/src');

require_once("vendor/autoload.php");

\speedy\Speedy::test(\speedy\Speedy::PHP_INC_PREF_POST);