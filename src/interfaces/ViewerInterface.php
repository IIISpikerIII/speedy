<?php
namespace speedyPack\interfaces;

interface ViewerInterface
{
    public function generateData($data);

    public function run($data);

    public static function model($class);
}