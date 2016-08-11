<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 10.08.16
 * Time: 20:04
 */
namespace speedy\interfaces;


use speedy\config\App;

abstract class TestAbstract
{
    private $part = 0;
    public $valueTest = [/*10, 100, 1000, 10000, 100000, 500000,*/ 100, 1000, 2000, 3000, 5000];
    public $qntTest = 5;
    public $data = [];
    public $testArray = [];

    public function run()
    {
        ini_set('memory_limit', 512000000);
        $this->clearData();
        foreach($this->valueTest as $size) {
            $qnt = 1;
            while($qnt <= $this->qntTest){
                $this->itemTest($size);
                $qnt++;
            }
        }
//        $this->getGraph();
        $data = $this->getData();
        $groupData = $this->getGroupData();
        $this->clearData();

        print App::render('test_result.php', ['data' => $data, 'groupData' => $groupData, 'testArray' => $this->testArray]);
    }

    public function setData($name, $size, $time, $part = null, $memory = null, $comment = null)
    {
        $db = App::db();
        $db->query("CREATE TABLE IF NOT EXISTS data (test_name, name, size, time, part, memory, comment)");

        $command = $db->prepare("INSERT INTO data(test_name, name, size, time, part, memory, comment) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $data = [__CLASS__, $name, $size, $time, $part, $memory, $comment];
        $command->execute($data);
    }

    public function getData()
    {
        $db = App::db();
        $result = $db->query('select * from data');
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        return $result->fetchAll();
    }

    public function getGroupData()
    {
        $tests = $this->getData();
        $groupTest = [];

        foreach($tests as $test) {
            $size = $test['size'];
            if(!isset($groupTest[$size])) {
                $groupTest[$size][$test['part']] = [];
            }

            $groupTest[$size][$test['part']][$test['name']] = $test;
        }

        return $groupTest;
    }

    public function clearData()
    {
        $db = App::db();
        $db->query("delete from data where test_name = '".__CLASS__."'");
//        $command->execute([__CLASS__]);
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
}