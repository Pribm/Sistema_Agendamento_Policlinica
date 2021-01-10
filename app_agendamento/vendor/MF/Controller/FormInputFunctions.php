<?php
namespace MF\Controller;

class FormInputFunctions{

    public static function getDatesFromRange($start, $end){
        $dates = array($start);
        while(end($dates) < $end){
            $dates[] = date('Y-m-d', strtotime(end($dates).' +1 day'));
        }
        return $dates;
    }
}
?>