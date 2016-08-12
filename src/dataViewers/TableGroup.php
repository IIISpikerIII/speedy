<?php
namespace speedy\dataViewers;

use speedy\config\App;
use speedy\interfaces\ViewerAbstract;

class TableGroup extends ViewerAbstract
{
    public $view = 'tableGroup.php';

    public function generateData($data){
        $groupNames = [];
        $groupTest = [];

        foreach($data as $test) {
            $size = $test['size'];
            if(!isset($groupTest[$size])) {
                $groupTest[$size][$test['part']] = [];
            }

            if(!in_array($test['name'], $groupNames)) {
                $groupNames[] = $test['name'];
            }

            $groupTest[$size][$test['part']][$test['name']] = $test;
        }

        return ['names' => $groupNames, 'groupTest' => $groupTest];
    }

    public function run($data)
    {
        $data = $this->generateData($data);
        return App::render('/viewer/'.$this->view, ['data' => $data['groupTest'], 'names' => $data['names']]);
    }

    public static function model($class = __CLASS__) {
        return parent::model($class);
    }
}