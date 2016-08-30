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

    const TESTER_PHP = 'speedyPack\testers\PhpTester';
    const TESTER_XHPROF = 'speedyPack\testers\XHprofTester';

    private $part = 0;
    protected $strategy = [];

    public $valueTest = [100, 1000, 2000, 3000, 5000];
    public $qntTest = 5;
    public $viewers = [];
    public $tester;
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

    protected function generatePart()
    {
        return ++$this->part;
    }

    protected function speedTest($method, $size)
    {
        return $this->tester->run($this, $method, $size);
    }

    protected function renderViewer(ViewerAbstract $viewer, $data)
    {
        return $viewer->run($data);
    }
}