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

class IncPrefVsPos {

    public $valueTest = [/*10, 100, 1000, 10000, 100000, 500000,*/ 100, 1000, 2000, 3000, 5000];
    public $qntTest = 5;
    public $data = [];

    public function getTime(){
        return microtime(true);
    }

    public function run()
    {
        ini_set('memory_limit', 512000000);
        $this->clearData();
        foreach($this->valueTest as $size) {
            print('SIZE: '.$size.'<br/>');
            $qnt = 1;
            while($qnt <= $this->qntTest){
                $this->itemTest($size);
                $qnt++;
            }
        }
//        $this->getGraph();
        $data = $this->getData();
        $this->clearData();

        print App::render('test_result.php', ['data' => $data]);
    }

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

    public function setData($name, $size, $time, $comment = null)
    {
        $db = App::db();
        $db->query("CREATE TABLE IF NOT EXISTS data (name, size, time, comment)");

        $command = $db->prepare("INSERT INTO data(name, size, time, comment) VALUES (?, ?, ?, ?)");
        $data = [$name, $size, $time, $comment];
        $command->execute($data);
    }

    public function getData()
    {
        $db = App::db();
        $result = $db->query('select * from data');
        $result->setFetchMode(\PDO::FETCH_ASSOC);
        return $result->fetchAll();
    }

    public function clearData()
    {
        $db = App::db();
        $db->query("delete from data");
    }

    public function itemTest($size)
    {
        //variable set for memory
        $time1 = $this->testPost($size);
        $time2 = $this->testPref($size);

        print(memory_get_usage(). ' bytes <br/>');
        $time1 = $this->testPost($size);
        print(memory_get_usage(). ' bytes <br/>');
        $time2 = $this->testPref($size);
        print(($time1 < $time2?'*':'').'Post: '.$time1.'<br/>');
        print(($time2 < $time1?'*':'').'Pref: '.$time2.'<br/>');
        $this->setData('Post', $size, $time1, '->');
        $this->setData('Pre', $size, $time2, '->');

        print(memory_get_usage(). ' bytes <br/>');
        $time2 = $this->testPref($size);
        print(memory_get_usage(). ' bytes <br/>');
        $time1 = $this->testPost($size);
        print(($time2 < $time1?'*':'').'Pref: '.$time2.'<br/>');
        print(($time1 < $time2?'*':'').'Post: '.$time1.'<br/>');
        $this->setData('Post', $size, $time1, '<-');
        $this->setData('Pre', $size, $time2, '<-');
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