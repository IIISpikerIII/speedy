<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 10.08.16
 * Time: 19:56
 */
namespace speedyPack\interfaces;

interface TestInterface
{
    public function run();
    public function itemTest($size);
}