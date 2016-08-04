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
        $posItem = 0;

        while($pos <= $size) {
            $pos++;
            $item = '';
            while ($posItem <= $itemSize) {
                $posItem++;
                $position = rand(0, $length-1);
                $item.= $symbol[$position];
            }

            $resultArray[] = $item;
        }

        return $resultArray;
    }


}