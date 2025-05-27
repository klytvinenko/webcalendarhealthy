<?php

namespace App\Services;

use App\Data;
use App\Models\Weight;
use App\Models\Workout;

class WeightService 
{
    public static function today(){
        $res= Weight::getWeight();
        return $res->value??null;
    }
    public static function bydate($date){
        $res= Weight::getWeight($date);
        return $res->value??null;
    }
}
