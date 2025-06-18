<?php

namespace App\Services;

use App\Models\Meal;
use App\Data;

class MenuService
{
    public static function menu($date = null)
    {
        
        $meals_today = $date === null ? Meal::today() : Meal::bydate($date);

        $sums = ['kcal' => 0, 'fat' => 0, 'protein' => 0,'carbonation' => 0, 'na' => 0, 'cellulose' => 0];

        foreach ($meals_today as $meal) {
            $sums['kcal'] += $meal->kcal;
            $sums['fat'] += $meal->fat;
            $sums['protein'] += $meal->protein;
            $sums['carbonation'] += $meal->carbonation;
            $sums['na'] += $meal->na;
            $sums['cellulose'] += $meal->cellulose;
        }

        $times = Data::mealtimesKeys();

        $meals_by_time = array_fill(0, count($times), []);
        $sums_by_time = array_fill(0, count($times), ['kcal' => 0, 'fat' => 0, 'protein' => 0,'carbonation' => 0, 'na' => 0, 'cellulose' => 0]);

        foreach ($meals_today as $meal) {
            $sums['kcal'] += $meal->kcal;
            $sums['fat'] += $meal->fat;
            $sums['protein'] += $meal->protein;
            $sums['carbonation'] += $meal->carbonation;
            $sums['na'] += $meal->na;
            $sums['cellulose'] += $meal->cellulose;

            $index = array_search($meal->time, $times);
            if ($index !== false) {
                $meals_by_time[$index][] = $meal;
                $sums_by_time[$index]['kcal'] += $meal->kcal;
                $sums_by_time[$index]['fat'] += $meal->fat;
                $sums_by_time[$index]['protein'] += $meal->protein;
                $sums_by_time[$index]['carbonation'] += $meal->carbonation;
                $sums_by_time[$index]['na'] += $meal->na;
                $sums_by_time[$index]['cellulose'] += $meal->cellulose;
            }
        }
        $sums_by_time[] = $sums;
        
        return [
            "data" => $meals_today,
            "by_time" => $meals_by_time,
            "sums" => $sums_by_time,
        ];
    }
}
