<?php

namespace App\Controllers;
use App\Data;
use App\DB;
use App\Models\User;
use App\Models\Recipe;
use App\Router;

class RecipeController extends Controller
{

    public function index()
    {
        $data=[
            "recipes"=>Recipe::all()
        ];
        self::render('Рецепти', 'profile/recipes','main',$data);
    }

    public function indexbyadmin()
    {
        self::render('Рецепти', 'admin/recipes','admin',[
            "recipes"=>Recipe::all()
        ]);
    }
    public function show($id)
    {
        self::render('Додати рецепт', 'profile_form/recipe');
    }
    public function add()
    {
        self::render('Додати рецепт', 'profile_form/recipe');
    }
    public function store($request)
    {
        self::render('Додати рецепт', 'profile_form/recipe');
    }
    public function addbyadmin()
    {
        self::render('Додати рецепт', 'admin_form/recipe','admin');
    }
    public function storerecipebyadmin($request)
    {
        Data::pa($request);
        Recipe::create([
            'title'=>$request['title'],
            'type'=>$request['type'],
            'description'=>$request['description'],
            'user_id'=>User::id(),
        ]);
        
    //     $recipe_id = DB::lastInsertId();
    //     if (isset($request['diets'])) {
    //         foreach ($request['diets'] as $diet_id) {
    //             DB::insert('recipe_in_diets', [
    //                 'recipe_id' => $recipe_id,
    //                 'diet_id' => $diet_id
    //             ]);
    //         }
    //     }
    //     Router::redirect('/admin/recipes');
    }
    public function edit()
    {
        self::render('Редагувати рецепт', 'profile_form/recipe_edit');
    }
    public function update($request)
    {
        self::render('Додати рецепт', 'profile_form/recipe');
    }
    public function delete($id)
    {
        self::render('Додати рецепт', 'profile_form/recipe');
    }
    public function deleterecipebyadmin($id)
    {
        DB::delete('meals',condition: "recipe_id=".$id);
        DB::delete('recipe_in_diets: als',"recipe_id=".$id);
        DB::delete('products_in_recipes',"recipe_id=".$id);
        DB::delete('liked_recipes',"recipe_id=".$id);
        Recipe::delete("id=".$id);
        // Router::redirect('/admin/recipes');
    }
    public function deleterecipe($id)
    {
        DB::delete('meals',condition: "recipe_id=".$id);
        DB::delete('recipe_in_diets: als',"recipe_id=".$id);
        DB::delete('products_in_recipes',"recipe_id=".$id);
        DB::delete('liked_recipes',"recipe_id=".$id);
        Recipe::delete("id=".$id);
        // Router::redirect('/profile/recipes');
    }
}
