<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 01.08.16
 * Time: 21:41
 */
namespace speedyPack\phpFunc;

use speedyPack\helpers\ArrayHelper;

class SizeofVsCount {

    public function getTime(){
        return microtime(true);
    }

    public function run()
    {
        ini_set('memory_limit', 512000000);

        $params = [/*10, 100, 1000, 10000, 100000, 500000, 800000,*/ 1000000];
        foreach($params as $size){
            print('SIZE: '.$size.'<br/>');
            $array = ArrayHelper::getRndArray($size,10);

            flush();
            $start_time = $this->gettime();
            sizeof($array);
            $stop_time = $this->gettime();
            $time = bcsub($stop_time,$start_time,6);
            print("Sizeof: ".$time."<br/>");

            flush();
            $start_time = $this->gettime();
            count($array);
            $stop_time = $this->gettime();
            $time = bcsub($stop_time,$start_time,6);
            print("Count: ".$time."<br/>");


            print("---------------------<br/>");
            unset($array);
            flush();
        }
    }
}