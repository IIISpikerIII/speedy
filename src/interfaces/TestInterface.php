<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 10.08.16
 * Time: 19:56
 */
namespace speedy\interfaces;

interface TestInterface
{

    public function run();
    public function itemTest($size);
    public function setData($name, $size, $time, $comment);
    public function getData();
    public function clearData();
}