<?php

namespace App\Services;

use App\Data;
use App\DB;
use App\Models\User;
use App\Models\Workout;

class UserService
{
    public static function norms()
    {
        $user=new User();
        return [
            "norms"=>[
                "kcal"=>$user->norms['kcal']??0,
                "protein"=>$user->norms['protein']??0,
                "fat"=>$user->norms['fat']??0,
                "carbonation"=>$user->norms['carbonation']??0,
                "na"=>$user->norms['na']??0,
                "cellulose"=>$user->norms['cellulose']??0,
            ],
            "breakfast"=>[
                "min"=>25,
                "max"=>25,
                "avg"=>25,
            ],
            "snack1"=>[
                "min"=>5,
                "max"=>10,
                "avg"=>7.5,
            ],
            "lunch"=>[
                "min"=>40,
                "max"=>45,
                "avg"=>42.5,
            ],
            "snack2"=>[
                "min"=>10,
                "max"=>15,
                "avg"=>12.5,
            ],
            "dinner"=>[
                "min"=>15,
                "max"=>20,
                "avg"=>17.5,
            ]

        ];
    }
    public static function have10LikedRecipes(){
        $liked_recipes=DB::select('liked_recipes','*','user_id='.user::id(),'id','10');
        return count($liked_recipes)>=10;
    }
}
