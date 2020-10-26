<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

defined('BASE_PATH') or define('BASE_PATH', __DIR__ . '/src');

require_once("vendor/autoload.php");

// Use a prepared test template
$speedy = new \speedy\Speedy();
print $speedy->runTestByName(\speedy\lists\TestList::PHP_ARR_SORT);

// Use custom functions
$pref = function ($size) {
	$testCounter = 0;
	for ($i = 0; $i < $size; $i++) {
		++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
		++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
		++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
		++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
	}
};

$post = function ($size) {
	$testCounter = 0;
	for ($i = 0; $i < $size; $i++) {
		$testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
		$testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
		$testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
		$testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
    }
};

print \speedy\Speedy::compare(['pref' => $pref, 'post' => $post]);