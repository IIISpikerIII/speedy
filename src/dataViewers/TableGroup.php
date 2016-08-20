<?php
namespace speedyPack\dataViewers;

use speedyPack\config\App;
use speedyPack\interfaces\ViewerAbstract;

class TableGroup extends ViewerAbstract
{
    public $view = 'tableGroup.php';

    public function generateData($data){
        $groupNames = [];
        $groupStat = [];
        $groupTest = [];

        foreach($data as $test) {
            $size = $test['size'];
            if(!isset($groupTest[$size])) {
                $groupTest[$size][$test['part']] = [];
                $groupStat[$size][$test['part']] = [
                    'maxTime' => false,
                    'minTime' => false,
                ];
            }

            $maxTime = &$groupStat[$size][$test['part']]['maxTime'];
            $minTime = &$groupStat[$size][$test['part']]['minTime'];

            if($maxTime === false || $maxTime < $test['time']){
                $maxTime = $test['time'];
            }

            if($minTime === false || $minTime > $test['time']){
                $minTime = $test['time'];
            }

            if(!in_array($test['name'], $groupNames)) {
                $groupNames[] = $test['name'];
            }

            $groupTest[$size][$test['part']][$test['name']] = $test;
        }

        return ['names' => $groupNames, 'groupTest' => $groupTest, 'groupStat' => $groupStat];
    }

    public function run($data)
    {
        $data = $this->generateData($data);
        return App::render('/viewer/'.$this->view, ['data' => $data['groupTest'], 'names' => $data['names'], 'stat' => $data['groupStat']]);
    }

    public static function model($class = __CLASS__) {
        return parent::model($class);
    }
}