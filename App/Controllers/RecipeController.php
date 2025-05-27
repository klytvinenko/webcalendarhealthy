<?php

namespace App\Controllers;
use App\Data;
use App\DB;
use App\Models\Diet;
use App\Models\User;
use App\Models\Recipe;
use App\Router;
use App\Services\RecipeService;

class RecipeController extends Controller
{

    public function index()
    {
        $item_on_page=12;
        $recipes = Recipe::pagination($item_on_page);
        $recipes=RecipeService::fullData($recipes);
        self::render('Рецепти', 'profile/recipes', 'main', [
            'user'=>new User(User::id()),
            'recipes'=>$recipes,
            'item_on_page'=>$item_on_page,
        ]);
    }

    public function indexbyadmin()
    {
        $item_on_page=12;
        $recipes = Recipe::pagination($item_on_page);
        $recipes=RecipeService::fullData($recipes);
        self::render('Рецепти', 'admin/recipes', 'admin', [
            'recipes'=>$recipes,
            'item_on_page'=>$item_on_page,
        ]);
    }
    
    public function show($params)
    {
        $id=$params['id'];
        $recipe=new Recipe($id);
        self::render("Перегляд рецепту", 'profile/recipe','main',[
            'recipe'=>$recipe
        ]);
    }
    public function showbyadmin($params)
    {
        $id=$params['id'];
        $recipe=new Recipe($id);
        self::render($recipe->title, 'admin/recipe','admin',[
            'recipe'=>$recipe
        ]);
    }
    public function add()
    {
        self::render('Додати рецепт', 'profile_form/recipe', 'main',[
            'user'=>new User()
        ]);
    }
    public function storerecipe($request)
    {
        Recipe::create([
            'title' => $request['title'],
            'type' => $request['type'],
            'description' => $request['description'],
            'user_id' => User::id(),
        ]);

        $recipe_id = DB::lastInsertId('recipes');
        for ($i = 0; $i < count($request['ingredients']); $i++) {
            DB::insert('products_in_recipes', [
                'recipe_id' => $recipe_id,
                'product_id' => $request['ingredients'][$i],
                'weight' => $request['ingredients_weigths'][$i],
                'user_id' => User::id(),
            ]);
        }
        if (isset($request['diets'])) {
            foreach ($request['diets'] as $diet_id) {
                DB::insert('recipe_in_diets', [
                    'recipe_id' => $recipe_id,
                    'diet_id' => $diet_id
                ]);
            }
        }
        Router::redirect('/profile/recipes');
    }
    public function addbyadmin()
    {
        self::render('Додати рецепт', 'admin_form/recipe', 'admin');
    }
    public function storerecipebyadmin($request)
    {
        Recipe::create([
            'title' => $request['title'],
            'type' => $request['type'],
            'description' => $request['description'],
            'user_id' => User::id(),
        ]);

        $recipe_id = DB::lastInsertId('recipes');
        for ($i = 0; $i < count($request['ingredients']); $i++) {
            DB::insert('products_in_recipes', [
                'recipe_id' => $recipe_id,
                'product_id' => $request['ingredients'][$i],
                'weight' => $request['ingredients_weigths'][$i],
                'user_id' => User::id(),
            ]);
        }
        if (isset($request['diets'])) {
            foreach ($request['diets'] as $diet_id) {
                DB::insert('recipe_in_diets', [
                    'recipe_id' => $recipe_id,
                    'diet_id' => $diet_id
                ]);
            }
        }
        Router::redirect('/admin/recipes');
    }
    public function edit($params)
    {
        $id = $params['id'];
        $recipe = new Recipe($id);
        $diet_ids=array_column($recipe->dietsFull(),'id');
        $diets = Diet::all();
        for($i=0;$i<count($diets);$i++) {
            if(in_array($diets[$i]['id'],$diet_ids)) $diets[$i]['checked']=true;
        }

        $recipe_types=Recipe::types();
        for($i=0;$i<count($recipe_types);$i++) {
            if($recipe_types[$i]['id']==strtolower($recipe->type->name)) $recipe_types[$i]['checked']=true;
        }
        self::render($recipe->title, 'profile_form/recipe_edit', 'main', [
            'recipe' => $recipe,
            'diets' => $diets,
            'recipe_types' => $recipe_types,
        ]);
    }
    public function editbyadmin($params)
    {
        $id = $params['id'];
        $recipe = new Recipe($id);
        $diet_ids=array_column($recipe->dietsFull(),'id');
        $diets = Diet::all();
        for($i=0;$i<count($diets);$i++) {
            if(in_array($diets[$i]['id'],$diet_ids)) $diets[$i]['checked']=true;
        }

        $recipe_types=Recipe::types();
        for($i=0;$i<count($recipe_types);$i++) {
            if($recipe_types[$i]['id']==strtolower($recipe->type->name)) $recipe_types[$i]['checked']=true;
        }
        self::render($recipe->title, 'admin_form/recipe_edit', 'admin', [
            'recipe' => $recipe,
            'diets' => $diets,
            'recipe_types' => $recipe_types,
        ]);
    }
    public function updaterecipe($params,$request)
    {
        $id=$params['id'];
        Recipe::update('id='.$id,[
            'title' => $request['title'],
            'type' => $request['type'],
            'description' => $request['description'],
            'user_id' => User::id(),
        ]);

        DB::delete('products_in_recipes','recipe_id='.$id);
        DB::delete('diets','recipe_id='.$id);

        for ($i = 0; $i < count($request['ingredients']); $i++) {
            DB::insert('products_in_recipes', [
                'recipe_id' => $id,
                'product_id' => $request['ingredients'][$i],
                'weight' => $request['ingredients_weigths'][$i],
                'user_id' => User::id(),
            ]);
        }
        if (isset($request['diets'])) {
            foreach ($request['diets'] as $diet_id) {
                DB::insert('recipe_in_diets', [
                    'recipe_id' => $id,
                    'diet_id' => $diet_id
                ]);
            }
        }
        Router::redirect('/profile/recipes');
    }
    public function updaterecipebyadmin($params,$request)
    {
        $id=$params['id'];
        Recipe::update('id='.$id,[
            'title' => $request['title'],
            'type' => $request['type'],
            'description' => $request['description'],
            'user_id' => User::id(),
        ]);

        DB::delete('products_in_recipes','recipe_id='.$id);
        DB::delete('diets','recipe_id='.$id);

        for ($i = 0; $i < count($request['ingredients']); $i++) {
            DB::insert('products_in_recipes', [
                'recipe_id' => $id,
                'product_id' => $request['ingredients'][$i],
                'weight' => $request['ingredients_weigths'][$i],
                'user_id' => User::id(),
            ]);
        }
        if (isset($request['diets'])) {
            foreach ($request['diets'] as $diet_id) {
                DB::insert('recipe_in_diets', [
                    'recipe_id' => $id,
                    'diet_id' => $diet_id
                ]);
            }
        }
        Router::redirect('/admin/recipes');
    }
    public function like($params)
    {
        $recipe_id = $params['id'];
        //is liked
        $res = DB::selectOne('liked_recipes', '*', 'user_id=' . User::id() . ' AND recipe_id=' . $recipe_id);
        if (is_null($res)) {
            //if no - add
            DB::insert('liked_recipes', [
                'user_id' => User::id(),
                'recipe_id' => $recipe_id,
            ]);
        } else {
            //if yes - remove
            DB::delete('liked_recipes', 'user_id=' . User::id() . ' AND recipe_id=' . $recipe_id);
        }
        Router::redirect('/profile/recipes');
    }
    public function deleterecipebyadmin($id)
    {
        DB::delete('meals', condition: "recipe_id=" . $id);
        DB::delete('recipe_in_diets: als', "recipe_id=" . $id);
        DB::delete('products_in_recipes', "recipe_id=" . $id);
        DB::delete('liked_recipes', "recipe_id=" . $id);
        Recipe::delete("id=" . $id);
        // Router::redirect('/admin/recipes');
    }
    public function deleterecipe($id)
    {
        DB::delete('meals', condition: "recipe_id=" . $id);
        DB::delete('recipe_in_diets', "recipe_id=" . $id);
        DB::delete('products_in_recipes', "recipe_id=" . $id);
        DB::delete('liked_recipes', "recipe_id=" . $id);
        Recipe::delete("id=" . $id);
        // Router::redirect('/profile/recipes');
    }
}
