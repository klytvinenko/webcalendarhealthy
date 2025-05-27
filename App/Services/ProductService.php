<?php

namespace App\Services;

use App\Data;
use App\DB;
use App\Models\Product;
use App\Models\User;
use App\Models\Workout;

class ProductService
{
    public static function isLiked($id)
    {
        $res = DB::selectOne('liked_products', '*', 'user_id=' . User::id() . ' AND product_id=' . $id);
        if (is_null($res))
            return false;
        else
            return true;
    }
}
