<?php
namespace speedy\dataViewers;

use speedy\config\App;
use speedy\interfaces\ViewerAbstract;

class TableAvg extends ViewerAbstract
{
    public $view = 'tableAvg.php';

    protected function groupData($data)
    {
        $groupData = [];
        $groupNames = [];
        foreach($data as $test) {
            $size = $test['size'];
            if(!isset($groupData[$size])) {
                $groupData[$size][$test['part']] = [];
            }
            $groupData[$size][$test['part']][$test['name']] = $test;

            if(!in_array($test['name'], $groupNames)) {
                $groupNames[] = $test['name'];
            }
        }

        return ['names' => $groupNames, 'data' => $groupData];
    }

    public function generateData($data)
    {
        $groupData = $this->groupData($data);

        $avgArray = [];
        foreach($groupData['data'] as $size => $parts) {

            if(!isset($avgArray[$size])) {
                $avgArray[$size] = [];
            }

            foreach($parts as $part) {
                $timeWinn = false;
                $nameWinn = [];

                foreach($part as $name => $test) {
                    if(!isset($avgArray[$size][$name])){
                        $avgArray[$size][$name] = 0;
                    }

                    if($timeWinn == $test['time']) {
                        $nameWinn[] = $test['name'];
                        continue;
                    }

                    if($timeWinn == false || $timeWinn > $test['time']){
                        $nameWinn = [$test['name']];
                        $timeWinn = $test['time'];
                    }
                }

                foreach($nameWinn as $name){
                    ++$avgArray[$size][$name];
                }
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