<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 10.08.16
 * Time: 20:04
 */
namespace speedyPack\interfaces;

use speedyPack\config\App;

abstract class ViewerAbstract implements ViewerInterface
{
    public $view = 'tableList.php';

    public function generateData($data){}

    public function run($data)
    {
        $data = $this->generateData($data);
        return App::render('/viewer/'.$this->view, compact('data'));
    }

    public static function model($class = __CLASS__)
    {
        return new $class;
    }
}