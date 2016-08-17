<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 10.08.16
 * Time: 20:04
 */
namespace speedyPack\dataViewers;

use speedyPack\config\App;
use speedyPack\interfaces\ViewerAbstract;

class TableList extends ViewerAbstract
{
    public $view = 'tableList.php';

    public function generateData($data){
        return $data;
    }

    public static function model($class = __CLASS__) {
        return parent::model($class);
    }
}