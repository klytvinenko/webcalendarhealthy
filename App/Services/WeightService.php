<?php

namespace App\Services;

use App\Data;
use App\Models\Workout;

class WeightService 
{
    public static function today(){
        $today=Data::today();
        $user_id=$_SESSION['user']['id'];
        $trainings=Workout::where('start_datetime='.$today.' AND user_id='.$user_id);
        $kcal=0;
        foreach ($trainings as $training) {
            $minutes=round(abs($training->end_datetime - $training->start_datetime) / 60,2). " minute";
            $kcal+=($minutes*$training->kcal)/60;
        }
        
        return [
            "trainings"=>$trainings,
            "kcal"=>$kcal,
        ];
    }
}
