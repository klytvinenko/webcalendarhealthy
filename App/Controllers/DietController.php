<?php

namespace App\Controllers;

use App\Data;
use App\DB;
use App\Models\User;
use App\Models\Diet;
use App\Router;
use App\Models\Allergy;
use App\Models\Product;

class DietController extends Controller
{
    public function indexbyadmin()
    {
        $diets = Diet::all();
        $allergies = Allergy::all();

        self::render('Дієти на алергени', 'admin/diet_and_allergies', 'admin', [
            'diets' => $diets,
            'allergies' => $allergies
        ]);
    }
    public function addbyadmin()
    {
        self::render('Додавання дієти', 'admin_form/diet', 'admin');
    }
    public function choose()
    {
        $user = new User(User::id());
        $diets = Diet::all();
        $allergies = Allergy::all();
        for ($i = 0; $i < count($diets); $i++) {
            if (in_array($diets[$i]['id'], $user->dietsIds())) $diets[$i]['checked'] = true;
        }
        for ($i = 0; $i < count($allergies); $i++) {
            if (in_array($allergies[$i]['id'], $user->allergiesIds())) $allergies[$i]['checked'] = true;
        }
        self::render(
            'Налаштування дієти',
            'profile_form/diet_and_allergies',
            'main',
            [
                'diets' => $diets,
                'allergies' => $allergies,
                'user' => $user,
            ]
        );
    }
    public function changediet($request)
    {
        $user_id = User::id();

        DB::delete('users_allergies', 'user_id=' . $user_id);
        DB::delete('users_diets', 'user_id=' . $user_id);

        if (isset($request['allergies'])) {
            foreach ($request['allergies'] as $allergy_id) {
                DB::insert('users_allergies', [
                    'user_id' => $user_id,
                    'allergy_id' => $allergy_id
                ]);
            }
        }

        if (isset($request['diets'])) {
            foreach ($request['diets'] as $diet_id) {
                DB::insert('users_diets', [
                    'user_id' => $user_id,
                    'diet_id' => $diet_id
                ]);
            }
        }
        Router::redirect('/profile/setting');
    }
    public function storedietbyadmin($request)
    {
        Diet::create([
            "name" => $request['title'],
            "description" => $request['description'],
        ]);
        Router::redirect('/admin/diet');
    }
    public function addlistbyadmin($params)
    {
        $id = $params['id'];
        $diet = new Diet($id);
        self::render('Додавання продуктів і рецептів', 'profile_form/diet_add_list', 'main', [
            'diet' => $diet,
        ]);
    }
    public function storelistbbyadmin()
    {
        self::render('Редагувати продукт', 'profile_form/product_edit', 'main', [
            'product' => Product::find($_GET['id'])
        ]);
    }
    public function editbyadmin($params)
    {
        $id = $params['id'];
        $diet = new Diet($id);
        self::render($diet->name, 'admin_form/diet_edit', 'admin', ['diet' => $diet]);
    }
    public function updatedietbyadmin($params, $request)
    {
        $id = $params['id'];
        Diet::update('id=' . $id, [
            "name" => $request['title'],
            "description" => $request['description'],
        ]);
        Router::redirect('/admin/diet');
    }
    public function deletedietbyadmin($id)
    {
        DB::delete('users_diets', condition: "diet_id=" . $id);
        DB::delete('recipe_in_diets', condition: "diet_id=" . $id);
        DB::delete('product_in_diets', condition: "diet_id=" . $id);
        Diet::delete("id=" . $id);
        // Router::redirect('/admin/diet');
    }
    public function deletediet($id)
    {
        DB::delete('users_diets', condition: "diet_id=" . $id);
        DB::delete('recipe_in_diets', condition: "diet_id=" . $id);
        DB::delete('product_in_diets', condition: "diet_id=" . $id);
        Diet::delete("id=" . $id);
        // Router::redirect('/profile/diet');
    }
}
