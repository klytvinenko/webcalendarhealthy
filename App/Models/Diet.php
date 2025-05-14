<?php

namespace App\Models;

use App\DB;
class Diet extends Model
{

    protected static $table = "diets"; 
    
    public static function titles_and_ids(){
        return DB::selectByQuery("SELECT id,name FROM `diets`;");
    }
    public  function recipes(){

        return [];
    }
    public  function products(){

    return [];
}
}
