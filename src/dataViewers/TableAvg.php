<?php
namespace speedyPack\dataViewers;

use speedyPack\config\App;
use speedyPack\interfaces\ViewerAbstract;

class TableAvg extends ViewerAbstract
{
    public $view = 'tableAvg.php';

    protected function groupData($data)
    {
        $groupData = [];
        $groupNames = [];
        $groupStat = [];

        foreach($data as $test) {
            $size = $test['size'];
            if(!isset($groupData[$size])) {
                $groupData[$size][$test['part']] = [];
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

            $groupData[$size][$test['part']][$test['name']] = $test;

            if(!in_array($test['name'], $groupNames)) {
                $groupNames[] = $test['name'];
            }
        }

        return ['names' => $groupNames, 'data' => $groupData, 'groupStat' => $groupStat];
    }

    public function generateData($data)
    {
        $groupData = $this->groupData($data);

        $avgArray = [];
        foreach($groupData['data'] as $size => $parts) {

            if(!isset($avgArray[$size])) {
                $avgArray[$size] = [];
            }

            foreach($parts as $numPart => $part) {
                $timeWinn = false;
                $nameWinn = [];
                $percentWinn = false;

                $groupData['groupStat'][$size]['avgPercent'] = [];
                foreach($part as $name => $test) {

                    $percent = (($groupData['groupStat'][$size][$numPart]['maxTime'] - $test['time'])/($groupData['groupStat'][$size][$numPart]['maxTime']))*100;

                    if(!isset($avgArray[$size][$name])){
                        $avgArray[$size][$name] = ['count' => 0, 'percent' => []];
                    }

                    if($timeWinn == $test['time']) {
                        $nameWinn[] = $test['name'];
                        $percentWinn = $percent;
                        continue;
                    }

                    if($timeWinn == false || $timeWinn > $test['time']){
                        $nameWinn = [$test['name']];
                        $timeWinn = $test['time'];
                        $percentWinn = $percent;
                    }
                }

                foreach($nameWinn as $name){
                    ++$avgArray[$size][$name]['count'];
                    //accumulate winn percents
                    $avgArray[$size][$name]['percent'][] = $percentWinn;
                }
            }

            //calc avg percent
            foreach($avgArray[$size] as &$partStat) {
                $percents = $partStat['percent'];
                $partStat['percent'] = count($percents) > 0? array_sum($percents) / count($percents):0;
            }
        }

        return ['data' => $avgArray, 'names' => $groupData['names']];
    }

    public function run($data)
    {
        $data = $this->generateData($data);
        return App::render('/viewer/'.$this->view, ['data' => $data['data'], 'names' => $data['names']]);
    }

    public static function model($class = __CLASS__) {
        return parent::model($class);
    }
}