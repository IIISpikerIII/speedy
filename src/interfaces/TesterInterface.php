<?php
namespace speedyPack\interfaces;

interface TesterInterface
{
    public function run(TestCore $object, $method, $size);
}