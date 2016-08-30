<?php
namespace speedyPack\testers;

use speedyPack\interfaces\TestCore;
use speedyPack\interfaces\TesterInterface;

class PhpTester implements TesterInterface
{
    public function run(TestCore $object, $method, $size)
    {
        $memory = $this->getMemory();
        $time = $this->getTime();

        call_user_func_array([$object, $method], [$size]);

        $time = $this->getTime($time);
        $memory = $this->getMemory($memory);
        return ['memory' => $memory, 'time' => $time];
    }

    protected function getTime($time = false)
    {
        return $time === false? microtime(true) : microtime(true) - $time;
    }

    protected function getMemory($memory = false)
    {
        return $memory === false? memory_get_usage() : memory_get_usage() - $memory;
    }
}