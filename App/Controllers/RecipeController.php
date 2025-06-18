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
    public function approve($params)
    {
        $id=$params['id'];
        Recipe::update('id=' . $id, [
            "user_id" => null,
        ]);
        Router::redirect('/admin/recipes');
    }
    public function replace($params)
    {
        $copy_id=$params['new_id'];
        $original_id=$params['original_id'];
        
        $copy=new Recipe($copy_id);
        $original=new Recipe($original_id);

        Recipe::update('id='.$original_id,[
            'title' => $copy->title,
            'type' => $copy->type,
            'description' => $copy->description,
        ]);

    //     //rechange new_id in DB
    //     DB::delete('allergies_on_products', 'product_id=' . $original_id);
    //     DB::delete('product_in_diets', 'product_id=' . $original_id);

    //     DB::update('allergies_on_products','product_id='.$copy_id,['product_id'=>$original_id]);
    //     DB::update('product_in_diets','product_id='.$copy_id,['product_id'=>$original_id]);
    //     DB::update('meals','product_id='.$copy_id,['product_id'=>$original_id]);
    //     DB::update('products_in_recipes','product_id='.$copy_id,['product_id'=>$original_id]);
    //     DB::update('liked_products','product_id='.$copy_id,['product_id'=>$original_id]);
    //     //delete with new_id
        RecipeService::delete($id);
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
        RecipeService::delete($id);
    }
    public function deleterecipe($id)
    {
        RecipeService::delete($id);
    }
}
