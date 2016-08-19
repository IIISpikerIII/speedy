<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 10.08.16
 * Time: 20:04
 */
namespace speedyPack\interfaces;


use speedyPack\config\App;

abstract class TestAbstract extends TestCore
{
    public $viewers = [TestCore::VIEWER_TLIST, TestCore::VIEWER_TGROUP, TestCore::VIEWER_TAVG, TestCore::VIEWER_GBUBLE];
    protected $strategy = [];

    public function run($onlyData = false)
    {
        $this->createDb();
        $this->clearData();
        foreach($this->valueTest as $size) {
            $qnt = 1;
            while($qnt <= $this->qntTest){
                $this->itemTest($size);
                $qnt++;
            }
        }

        return $onlyData? $this->getData() : $this->render();
    }

    public function render()
    {
        $title = $this->name;
        $data = $this->getData();
        $viewers = [];
        foreach($this->viewers as $viewer){
            $viewers[] = $this->renderViewer(new $viewer, $data);
        }

        $this->clearData();
        return App::render($this->view.'.php', compact('viewers', 'title'));
    }

    public function itemTest($size)
    {
        if(sizeof($this->strategy) == 0) {
            return;
        }

        //variable set for memory
        $part = $this->generatePart();
        $comment = implode('-', $this->strategy[0]);
        foreach($this->strategy[0] as $test){
            $time1 = $this->speedTest($test, $size);
            $this->setData(self::DUMMY_NAME, $size, $time1['time'], $part, $time1['memory'],$comment, self::DUMMY_NAME);
        }

        foreach($this->strategy as $strategy){
            $part = $this->generatePart();
            $comment = implode('-', $strategy);
            foreach($strategy as $test){
                $time1 = $this->speedTest($test, $size);
                $this->setData($test, $size, $time1['time'], $part, $time1['memory'],$comment);
            }
        }
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