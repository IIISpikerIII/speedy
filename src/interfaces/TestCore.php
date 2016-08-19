<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 10.08.16
 * Time: 20:04
 */
namespace speedyPack\interfaces;


use speedyPack\config\App;

abstract class TestCore
{
    const DUMMY_NAME = 'dummy';
    const VIEWER_TLIST = 'speedyPack\dataViewers\TableList';
    const VIEWER_GBUBLE = 'speedyPack\dataViewers\GraphBuble';
    const VIEWER_TAVG = 'speedyPack\dataViewers\TableAvg';
    const VIEWER_TGROUP = 'speedyPack\dataViewers\TableGroup';

    private $part = 0;
    protected $strategy = [];

    public $valueTest = [100, 1000, 2000, 3000, 5000];
    public $qntTest = 5;
    public $viewers = [];
    public $name = 'Speedy test';
    public $view = 'test_result';

    public function render(){}
    public function itemTest($size){}
    public function run($onlyData = false){}

    protected function createDb()
    {
        $db = App::db();
        $db->query("CREATE TABLE IF NOT EXISTS data (test_name, name, size, time, part, memory, comment)");
    }

    protected function setData($name, $size, $time, $part = null, $memory = null, $comment = null, $testName = __CLASS__)
    {
        $db = App::db();
        $this->createDb();

        $command = $db->prepare("INSERT INTO data(test_name, name, size, time, part, memory, comment) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $data = [$testName, $name, $size, $time, $part, $memory, $comment];
        $command->execute($data);
    }

    protected function getData()
    {
        $db = App::db();
        $result = $db->query('select * from data where test_name = "'.__CLASS__.'"');
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        return $result->fetchAll();
    }

    protected function clearData()
    {
        $db = App::db();
        $command = $db->prepare("delete from data where test_name IN (?, ?)");
        $command->execute([__CLASS__, self::DUMMY_NAME]);
    }

    protected function getTime($time = false)
    {
        return $time === false? microtime(true) : microtime(true) - $time;
    }

    protected function getMemory($memory = false)
    {
        return $memory === false? memory_get_usage() : memory_get_usage() - $memory;
    }

    protected function generatePart()
    {
        return ++$this->part;
    }

    protected function speedTest($method, $size)
    {
        $memory = $this->getMemory();
        $time = $this->getTime();
        call_user_func_array([$this, $method], [$size]);
        $time = $this->getTime($time);
        $memory = $this->getMemory($memory);
        return ['memory' => $memory, 'time' => $time];
    }

    protected function renderViewer(ViewerAbstract $viewer, $data)
    {
        return $viewer->run($data);
    }
}