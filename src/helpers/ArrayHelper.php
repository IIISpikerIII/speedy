<?php
/**
 * Created by PhpStorm.
 * User: spiker
 * Date: 01.08.16
 * Time: 22:57
 */
namespace speedy\helpers;

class ArrayHelper {

    public static function getRndArray($size = 10, $itemSize = 6)
    {
        $resultArray = [];
        $symbol = 'ABCDEFGHIJKLMNOPQRSTUVWXYZАzyxwvutsrqponmlkjihgfedcbaаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя123465790';
        $length = strlen($symbol);
        $pos = 0;

        while($pos <= $size) {
            $posItem = 0;
            $pos++;
            $item = '';

            while ($posItem <= $itemSize) {
                $posItem++;
                $position = rand(0, $length-1);
                $item.= $symbol[$position];
            }

            $resultArray[$pos.'_'.$pos] = $item;
        }

        return $resultArray;
    }


    public static function getRndArrayNum($size = 10, $itemMaxSize = 999999)
    {
        $resultArray = [];
        $pos = 0;

        while($pos <= $size) {
            $pos++;
            $item = rand(0, $itemMaxSize);
            $resultArray[] = $item;
        }

        return $resultArray;
    }
}