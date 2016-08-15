<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 10.08.16
 * Time: 20:04
 */
namespace speedy\interfaces;


use speedy\config\App;

abstract class TestAbstract extends TestCore
{
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

    public function render() {
        $data = $this->getData();
        $tableList = TableList::model()->run($data);
        $tableGroup = TableGroup::model()->run($data);
        $graphBuble  = GraphBuble::model()->run($data);
        $tableAvg = TableAvg::model()->run($data);

        $viewers = compact('tableList', 'tableGroup', 'tableAvg', 'graphBuble');
        print App::render('test_result.php', compact('viewers'));
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