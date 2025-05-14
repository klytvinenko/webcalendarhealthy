<?php

namespace App\Models;

use App\DB;
class Product extends Model
{

    protected static $table = "products";

    public static function fulldata(){
        $products=DB::select('products','*','','','10');
        foreach ($products as $product) {
            $product['diets']="";
            $product['allergies']='';
        }
        return $products;
    }
    public function allergies(){
        return [];
    }
    public function diets(){
        return [];

    }
}
