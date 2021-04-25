<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function getMonths()
    {
        $months = array();
        for ($i = 1; $i < 13; $i++) {
            $timestamp = mktime(0, 0, 0, date('n') - $i, 1);
            $months[date('n', $timestamp)] = date('F', $timestamp);
        }
        return $months;
    }

    public function getYears()
    {
        $years = [];
        $workTimes = WorkTime::find();
        $workTimeArray = $workTimes->toArray();
        foreach ($workTimeArray as $workTime){
            $years[$workTime['year']] = $workTime['year'];
        }
        return array_unique($years);
    }

}
