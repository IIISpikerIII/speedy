<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 10.08.16
 * Time: 20:04
 */
namespace speedy\interfaces;


use speedy\config\App;

abstract class TestCore
{
    const DUMMY_NAME = 'dummy';
    private $part = 0;
    public $valueTest = [/*10, 100, 1000, 10000, 100000, 500000,*/ 100, 1000, 2000, 3000, 5000];
    public $qntTest = 5;

    public function render(){}
    public function itemTest($size){}

    public function run()
    {
        ini_set('memory_limit', 512000000);
        $this->createDb();
        $this->clearData();
        foreach($this->valueTest as $size) {
            $qnt = 1;
            while($qnt <= $this->qntTest){
                $this->itemTest($size);
                $qnt++;
            }
        }

        $this->render();
        $this->clearData();
    }

    protected function createDb()
    {
        $db = App::db();
        $db->query("CREATE TABLE IF NOT EXISTS data (test_name, name, size, time, part, memory, comment)");
    }

    public function setData($name, $size, $time, $part = null, $memory = null, $comment = null, $testName = __CLASS__)
    {
        $db = App::db();
        $this->createDb();

        $command = $db->prepare("INSERT INTO data(test_name, name, size, time, part, memory, comment) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $data = [$testName, $name, $size, $time, $part, $memory, $comment];
        $command->execute($data);
    }

    public function getData()
    {
        $db = App::db();
        $result = $db->query('select * from data where test_name = "'.__CLASS__.'"');
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        return $result->fetchAll();
    }

    public function clearData()
    {
        $db = App::db();
        $command = $db->prepare("delete from data where test_name IN (?, ?)");
        $command->execute([__CLASS__, self::DUMMY_NAME]);
    }

    public function getTime($time = false)
    {
        return $time === false? microtime(true) : microtime(true) - $time;
    }

    public function getMemory($memory = false)
    {
        return $memory === false? memory_get_usage() : memory_get_usage() - $memory;
    }

    public function generatePart()
    {
        return ++$this->part;
    }

    public function speedTest($method, $size)
    {
        $memory = $this->getMemory();
        $time = $this->getTime();
        call_user_func_array([$this, $method], [$size]);
        $time = $this->getTime($time);
        $memory = $this->getMemory($memory);
        return ['memory' => $memory, 'time' => $time];
    }
}