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
    public static function update($id,$request)
    {
        Product::update('id=' . $id, [
            "title" => $request['title'],
            "type" => isset($request['is_can_be_meal']) ? ($request['is_can_be_meal'] == "on" ? 'product' : 'ingredient') : 'ingredient',
            "kcal" => $request['kcal'],
            "fat" => $request['fat'],
            "protein" => $request['protein'],
            "carbonation" => $request['carbonation'],
            "na" => $request['na'],
            "cellulose" => $request['cellulose'],
        ]);

        DB::delete('allergies_on_products', 'product_id=' . $id);
        DB::delete('product_in_diets', 'product_id=' . $id);

        if (isset($request['allergies'])) {
            foreach ($request['allergies'] as $allergy_id) {
                DB::insert('allergies_on_products', [
                    'product_id' => $id,
                    'allergy_id' => $allergy_id
                ]);
            }
        }
        if (isset($request['diets'])) {

            foreach ($request['diets'] as $diet_id) {
                DB::insert('product_in_diets', [
                    'product_id' => $id,
                    'diet_id' => $diet_id
                ]);
            }
        }
    }
    public static function create($request,bool $by_admin=false)
    {
        Product::create([
            "title" => $request['title'],
            "type" => isset($request['is_can_be_meal']) ? ($request['is_can_be_meal'] == "on" ? 'product' : 'ingredient') : 'ingredient',
            "kcal" => $request['kcal'],
            "fat" => $request['fat'],
            "protein" => $request['protein'],
            "carbonation" => $request['carbonation'],
            "na" => $request['na'],
            "cellulose" => $request['cellulose'],
            "user_id"=> $by_admin?null:User::id()
        ]); 
        $product_id = DB::lastInsertId('products');
        if (isset($request['allergies'])) {
            foreach ($request['allergies'] as $allergy_id) {
                DB::insert('allergies_on_products', [
                    'product_id' => $product_id,
                    'allergy_id' => $allergy_id
                ]);
            }
        }
        if (isset($request['diets'])) {
            foreach ($request['diets'] as $diet_id) {
                DB::insert('product_in_diets', [
                    'product_id' => $product_id,
                    'diet_id' => $diet_id
                ]);
            }
        }
    }
    public static function approve($id)
    {
        Product::update('id='.$id,[
            'user_id'=>null
        ]);
    }
    public static function replacement($original_id,$copy_id)
    {
        Product::update('id='.$id,[
            'user_id'=>null
        ]);
    }
    public static function findCopies($id)
    {
        $original_item=new Product($id);
        $copies=DB::select("SELECT id FROM products WHERE title=".$original_item->title);
        $res=[];
        foreach ($copies as $copy_id) {
            $res[]=new Product($copy_id);
        }
        return $res;
    }
    
    public static function delete($id)
    {
        DB::delete('meals', "product_id=" . $id);
        DB::delete('products_in_recipes', "product_id=" . $id);
        DB::delete('product_in_diets', "product_id=" . $id);
        DB::delete('allergies_on_products',  "product_id=" . $id);
        DB::delete('liked_products',  "product_id=" . $id);
        Product::delete("id=" . $id);
    }
}
