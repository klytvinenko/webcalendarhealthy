<?php

namespace App\Models;

use App\DB;
class Workout extends Model
{
    protected static $table = "workouts";

    public static function types(){
        
        // return DB::selectByQuery("SELECT type FROM workouts GROUP BY type");
    }
}
