<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 01.08.16
 * Time: 21:41
 */
namespace speedy\phpFunc;

use speedy\config\App;
use Ghunti\HighchartsPHP\Highchart;
use Ghunti\HighchartsPHP\HighchartJsExpr;
use speedy\interfaces\TestAbstract;
use speedy\interfaces\TestInterface;

class IncPrefVsPos extends TestAbstract implements TestInterface {

    public $valueTest = [/*10, 100, 1000, 10000, 100000, 500000,*/ 100, 1000, 2000, 3000, 5000];
    public $qntTest = 5;
    public $data = [];
    public $testArray = ['Post', 'Pre'];

    public function getGraph()
    {
        $chart = new Highchart();
        $chart->chart = [
            'renderTo' => 'container',
            'type' => 'scatter',
            'zoomType' => 'xy',
        ];
        $chart->plotOptions->scatter->marker->radius = 5;
        $chart->plotOptions->scatter->marker->states->hover->enabled = 1;
        $chart->plotOptions->scatter->marker->states->hover->lineColor = "rgb(100,100,100)";
        $chart->plotOptions->scatter->states->hover->marker->enabled = false;

        $dataArr = [];
        foreach($this->data as $data) {

            if(!isset($dataArr[$data['n']])) {
                $dataArr[$data['n']] = [
                    'name' => $data['n'],
                    'color' => $data['n']=='Pre'? "rgba(223, 83, 83, .5)":"rgba(119, 152, 191, .5)",
                    'data' => []
                ];
            }
            $dataArr[$data['n']]['data'][] = [ $data['t'], $data['s'] ];

        }

//        $chart->series['11'] = array(
//            'name' => "Female",
//            'color' => "rgba(223, 83, 83, .5)",
//            'data' => array(
//                array(
//                    161.2,
//                    51.6
//                ),
//            )
//        );
//        print_r($dataArr);
        $chart->series = array_values($dataArr);


        $chart->printScripts();
        echo '<div id="container"></div>';
        echo '<script>'.$chart->render("chart").'</script>';

    }

    public function itemTest($size)
    {
        //variable set for memory
        $time1 = $this->testPost($size);
        $time2 = $this->testPref($size);
        $part = $this->generatePart();

        $time1 = $this->testPost($size);
        $time2 = $this->testPref($size);
        $this->setData('Post', $size, $time1['time'], $part, $time1['memory'],'->');
        $this->setData('Pre', $size, $time2['time'], $part, $time2['memory'], '->');

        $part = $this->generatePart();
        $time2 = $this->testPref($size);
        $time1 = $this->testPost($size);
        $this->setData('Post', $size, $time1['time'], $part, $time1['memory'], '<-');
        $this->setData('Pre', $size, $time2['time'], $part, $time2['memory'], '<-');
    }

    public function testPref($size)
    {
        $testCounter = 0;
        $memory = $this->getMemory();
        $time = $this->getTime();
        for($i=0;$i<$size;$i++) {
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
        }
        $time = $this->getTime($time);
        $memory = $this->getMemory($memory);
        return ['memory' => $memory, 'time' => $time];
    }

    public function testPost($size)
    {
        $testCounter = 0;
        $memory = $this->getMemory();
        $time = $this->getTime();
        for($i=0;$i<$size;$i++) {
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
        }
        $time = $this->getTime($time);
        $memory = $this->getMemory($memory);
        return ['memory' => $memory, 'time' => $time];
    }
}