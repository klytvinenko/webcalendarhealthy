<?php

namespace App\Services;

use App\Data;
use App\DB;
use App\Models\User;
use App\Models\Weight;
use App\Models\Workout;

class WeightService 
{
    public static function today(){
        $res= Weight::getWeight(Data::today());
        return $res->value??null;
    }
    public static function bydate($date){
        $res= Weight::getWeight($date);
        return $res->value??null;
    }
    public static function weightProgress()
    {
        return DB::selectByQuery('SELECT w.weigth as weigth, max(w.date_of_update) as date_of_update FROM weigths as w WHERE w.user_id=' . User::id() . ' GROUP BY w.date_of_update ORDER BY w.date_of_update;');
    }
}
