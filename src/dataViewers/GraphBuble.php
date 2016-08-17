<?php
namespace speedyPack\dataViewers;

use Ghunti\HighchartsPHP\Highchart;
use speedyPack\config\App;
use speedyPack\interfaces\ViewerAbstract;

class GraphBuble extends ViewerAbstract
{
    public $view = 'graphBuble.php';

    public function generateData($data)
    {
        $dataArr = [];
        $groupNames = [];

        foreach($data as $row) {

            if(!isset($dataArr[$row['name']])) {
                $dataArr[$row['name']] = [
                    'name' => $row['name'],
                    'data' => []
                ];
            }

            if(!in_array($row['name'], $groupNames)) {
                $groupNames[] = $row['name'];
            }

            $dataArr[$row['name']]['data'][] = [ $row['time']*1, $row['size']*1 ];
        }

        return $dataArr;
    }

    public function run($data)
    {
        $data = $this->generateData($data);

        $chart = new Highchart();
        $chart->chart = [
            'renderTo' => 'container',
            'type' => 'scatter',
            'zoomType' => 'xy',
        ];
        $chart->plotOptions->scatter->marker->radius = 8;
        $chart->plotOptions->scatter->marker->states->hover->enabled = 1;
        $chart->plotOptions->scatter->marker->states->hover->lineColor = "rgb(100,100,100)";
        $chart->plotOptions->scatter->states->hover->marker->enabled = false;
        $chart->series = array_values($data);

        $chart->printScripts();
        $chart =  '<script>'.$chart->render("chart").'</script>';

        return App::render('/viewer/'.$this->view, compact('chart'));
    }

    public static function model($class = __CLASS__) {
        return parent::model($class);
    }
}