<?php

namespace App\Services;

use App\Data;
use App\DB;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Workout;

class RecipeService
{
    public static function fullData($recipes)
    {
        $new_recipes=[];
        foreach ($recipes as $recipe) {
            array_push($new_recipes,new Recipe($recipe));
        }
        return $new_recipes;
    }
    public static function isLiked($id)
    {
        $res = DB::selectOne('liked_recipes', '*', 'user_id=' . User::id() . ' AND recipe_id=' . $id);
        if (is_null($res))
            return false;
        else
            return true;
    }
}
