<?php

namespace App\Models;

use App\DB;
class Allergy extends Model
{
    protected static $table = "allergies";

    public static function titles_and_ids()
    {
        return DB::selectByQuery("SELECT id,name FROM allergies;");
    }
}
