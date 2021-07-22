<?php

use Carbon\Carbon ;

function generateFileName($name){

    $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;
        $second = Carbon::now()->second;
        $microsecond = Carbon::now()->microsecond;

        return $year.'_'.$month.'_'.$day.'_'.$second.'_'.$microsecond.'_'.$name ;

}


function convertShamsiToGregorianDate($date)
{
    if($date == null){
        return null;
    }
    $pattern = "/[-\s]/";
    $shamsiDateSplit = preg_split($pattern, $date);

    $arrayGergorianDate = verta()->getGregorian($shamsiDateSplit[0], $shamsiDateSplit[1], $shamsiDateSplit[2]);

    return implode("-", $arrayGergorianDate) . " " . $shamsiDateSplit[3];
}
