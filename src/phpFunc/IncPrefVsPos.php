<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 01.08.16
 * Time: 21:41
 */
namespace speedy\phpFunc;

use Ghunti\HighchartsPHP\Highchart;

class IncPrefVsPos {

    public $valueTest = [/*10, 100, 1000, 10000, 100000, 500000, 100000,*/ 1000000];
    public $qntTest = 1;

    public function getTime(){
        return microtime(true);
    }

    public function run()
    {
        ini_set('memory_limit', 512000000);
        foreach($this->valueTest as $size) {
            print('SIZE: '.$size.'<br/>');
            $qnt = 1;
            while($qnt <= $this->qntTest){
                $this->itemTest($size);
                $qnt++;
            }
        }
        $this->getGraph();
    }

    public function getGraph()
    {
        $chart = new Highchart(Highchart::HIGHSTOCK);
        $chart->title->text = 'Monthly Average Temperature';
        $chart->title->x = -20;
        $chart->series[0]->name = 'Tokyo';
        $chart->series[0]->data = array(7.0, 6.9, 9.5);

        $chart->printScripts();
        $chart->renderTo = "chart";
        echo '<div id="chart"></div>';
        echo '<script>'.$chart->render("chart").'</script>';

    }

    public function itemTest($size)
    {
        $time1 = $this->testPost($size);
        $time2 = $this->testPref($size);
        print(($time1 < $time2?'*':'').'Post: '.$time1.'<br/>');
        print(($time2 < $time1?'*':'').'Pref: '.$time2.'<br/>');

        $time2 = $this->testPref($size);
        $time1 = $this->testPost($size);
        print(($time2 < $time1?'*':'').'Pref: '.$time2.'<br/>');
        print(($time1 < $time2?'*':'').'Post: '.$time1.'<br/>');
        print('----------------------- <br/>');
    }

    public function testPref($size)
    {
        $testCounter = 0;
        $startTime = $this->getTime();
        for($i=0;$i<$size;$i++) {
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
            ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter; ++$testCounter;
        }
        return ($this->getTime() - $startTime);
    }

    public function testPost($size)
    {
        $testCounter = 0;
        $startTime = $this->getTime();
        for($i=0;$i<$size;$i++) {
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
            $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++; $testCounter++;
        }
        return ($this->getTime() - $startTime);
    }
}