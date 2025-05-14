<?php

namespace App\Controllers;

use App\Data;
use App\DB;
use App\Models\Product;
use App\Router;
class ProductController extends Controller
{
    public function index()
    {
        $products = [
            ['name' => 'Яблуко', 'type' => true, 'calories' => 52, 'protein' => 0.3, 'fat' => 0.2, 'carbohydrates' => 14, 'sodium' => 1, 'fiber' => 2.4],
            ['name' => 'Куряче філе', 'type' => false, 'calories' => 165, 'protein' => 31, 'fat' => 3.6, 'carbohydrates' => 0, 'sodium' => 74, 'fiber' => 0],
            ['name' => 'Овес', 'type' => false, 'calories' => 389, 'protein' => 16.9, 'fat' => 6.9, 'carbohydrates' => 66.3, 'sodium' => 2, 'fiber' => 10.6],
            ['name' => 'Мигдаль', 'type' => false, 'calories' => 579, 'protein' => 21.2, 'fat' => 49.9, 'carbohydrates' => 21.6, 'sodium' => 1, 'fiber' => 12.5],
            ['name' => 'Броколі', 'type' => false, 'calories' => 34, 'protein' => 2.8, 'fat' => 0.4, 'carbohydrates' => 6.6, 'sodium' => 33, 'fiber' => 2.6],
            ['name' => 'Авокадо', 'type' => true, 'calories' => 160, 'protein' => 2, 'fat' => 14.7, 'carbohydrates' => 8.5, 'sodium' => 7, 'fiber' => 6.7],
            ['name' => 'Гречка', 'type' => true, 'calories' => 343, 'protein' => 13.3, 'fat' => 3.4, 'carbohydrates' => 71.5, 'sodium' => 1, 'fiber' => 10],
            ['name' => 'Яйце', 'type' => false, 'calories' => 155, 'protein' => 13, 'fat' => 11, 'carbohydrates' => 1.1, 'sodium' => 124, 'fiber' => 0],
            ['name' => 'Тунець консервований', 'type' => false, 'calories' => 132, 'protein' => 28, 'fat' => 1.3, 'carbohydrates' => 0, 'sodium' => 247, 'fiber' => 0],
            ['name' => 'Йогурт натуральний', 'type' => false, 'calories' => 61, 'protein' => 3.5, 'fat' => 3.3, 'carbohydrates' => 4.7, 'sodium' => 46, 'fiber' => 0],
            ['name' => 'Сир твердий', 'type' => false, 'calories' => 402, 'protein' => 25, 'fat' => 33, 'carbohydrates' => 1.3, 'sodium' => 621, 'fiber' => 0],
            ['name' => 'Лосось', 'type' => false, 'calories' => 208, 'protein' => 20, 'fat' => 13, 'carbohydrates' => 0, 'sodium' => 59, 'fiber' => 0],
            ['name' => 'Банан', 'type' => true, 'calories' => 89, 'protein' => 1.1, 'fat' => 0.3, 'carbohydrates' => 23, 'sodium' => 1, 'fiber' => 2.6],
            ['name' => 'Капуста', 'type' => false, 'calories' => 25, 'protein' => 1.3, 'fat' => 0.1, 'carbohydrates' => 5.8, 'sodium' => 18, 'fiber' => 2.5],
            ['name' => 'Помідор', 'type' => true, 'calories' => 18, 'protein' => 0.9, 'fat' => 0.2, 'carbohydrates' => 3.9, 'sodium' => 5, 'fiber' => 1.2],
            ['name' => 'Огірок', 'type' => false, 'calories' => 15, 'protein' => 0.7, 'fat' => 0.1, 'carbohydrates' => 3.6, 'sodium' => 2, 'fiber' => 0.5],
            ['name' => 'Горох зелений', true => 'овоч', 'calories' => 81, 'protein' => 5.4, 'fat' => 0.4, 'carbohydrates' => 14.5, 'sodium' => 5, 'fiber' => 5.1],
            ['name' => 'Індичка філе', 'type' => false, 'calories' => 135, 'protein' => 30, 'fat' => 1, 'carbohydrates' => 0, 'sodium' => 50, 'fiber' => 0],
            ['name' => 'Кіноа', 'type' => false, 'calories' => 368, 'protein' => 14.1, 'fat' => 6.1, 'carbohydrates' => 64.2, 'sodium' => 5, 'fiber' => 7],
            ['name' => 'Чіа насіння', 'type' => false, 'calories' => 486, 'protein' => 16.5, 'fat' => 30.7, 'carbohydrates' => 42.1, 'sodium' => 16, 'fiber' => 34.4],


        ];
        $products = Product::all();
        self::render('Продукти', 'profile/products', 'main', [
            'products' => $products
        ]);
    }
    public function indexbyadmin()
    {
        $products = [
            ['name' => 'Яблуко', 'type' => true, 'calories' => 52, 'protein' => 0.3, 'fat' => 0.2, 'carbohydrates' => 14, 'sodium' => 1, 'fiber' => 2.4],
            ['name' => 'Куряче філе', 'type' => false, 'calories' => 165, 'protein' => 31, 'fat' => 3.6, 'carbohydrates' => 0, 'sodium' => 74, 'fiber' => 0],
            ['name' => 'Овес', 'type' => false, 'calories' => 389, 'protein' => 16.9, 'fat' => 6.9, 'carbohydrates' => 66.3, 'sodium' => 2, 'fiber' => 10.6],
            ['name' => 'Мигдаль', 'type' => false, 'calories' => 579, 'protein' => 21.2, 'fat' => 49.9, 'carbohydrates' => 21.6, 'sodium' => 1, 'fiber' => 12.5],
            ['name' => 'Броколі', 'type' => false, 'calories' => 34, 'protein' => 2.8, 'fat' => 0.4, 'carbohydrates' => 6.6, 'sodium' => 33, 'fiber' => 2.6],
            ['name' => 'Авокадо', 'type' => true, 'calories' => 160, 'protein' => 2, 'fat' => 14.7, 'carbohydrates' => 8.5, 'sodium' => 7, 'fiber' => 6.7],
            ['name' => 'Гречка', 'type' => true, 'calories' => 343, 'protein' => 13.3, 'fat' => 3.4, 'carbohydrates' => 71.5, 'sodium' => 1, 'fiber' => 10],
            ['name' => 'Яйце', 'type' => false, 'calories' => 155, 'protein' => 13, 'fat' => 11, 'carbohydrates' => 1.1, 'sodium' => 124, 'fiber' => 0],
            ['name' => 'Тунець консервований', 'type' => false, 'calories' => 132, 'protein' => 28, 'fat' => 1.3, 'carbohydrates' => 0, 'sodium' => 247, 'fiber' => 0],
            ['name' => 'Йогурт натуральний', 'type' => false, 'calories' => 61, 'protein' => 3.5, 'fat' => 3.3, 'carbohydrates' => 4.7, 'sodium' => 46, 'fiber' => 0],
            ['name' => 'Сир твердий', 'type' => false, 'calories' => 402, 'protein' => 25, 'fat' => 33, 'carbohydrates' => 1.3, 'sodium' => 621, 'fiber' => 0],
            ['name' => 'Лосось', 'type' => false, 'calories' => 208, 'protein' => 20, 'fat' => 13, 'carbohydrates' => 0, 'sodium' => 59, 'fiber' => 0],
            ['name' => 'Банан', 'type' => true, 'calories' => 89, 'protein' => 1.1, 'fat' => 0.3, 'carbohydrates' => 23, 'sodium' => 1, 'fiber' => 2.6],
            ['name' => 'Капуста', 'type' => false, 'calories' => 25, 'protein' => 1.3, 'fat' => 0.1, 'carbohydrates' => 5.8, 'sodium' => 18, 'fiber' => 2.5],
            ['name' => 'Помідор', 'type' => true, 'calories' => 18, 'protein' => 0.9, 'fat' => 0.2, 'carbohydrates' => 3.9, 'sodium' => 5, 'fiber' => 1.2],
            ['name' => 'Огірок', 'type' => false, 'calories' => 15, 'protein' => 0.7, 'fat' => 0.1, 'carbohydrates' => 3.6, 'sodium' => 2, 'fiber' => 0.5],
            ['name' => 'Горох зелений', true => 'овоч', 'calories' => 81, 'protein' => 5.4, 'fat' => 0.4, 'carbohydrates' => 14.5, 'sodium' => 5, 'fiber' => 5.1],
            ['name' => 'Індичка філе', 'type' => false, 'calories' => 135, 'protein' => 30, 'fat' => 1, 'carbohydrates' => 0, 'sodium' => 50, 'fiber' => 0],
            ['name' => 'Кіноа', 'type' => false, 'calories' => 368, 'protein' => 14.1, 'fat' => 6.1, 'carbohydrates' => 64.2, 'sodium' => 5, 'fiber' => 7],
            ['name' => 'Чіа насіння', 'type' => false, 'calories' => 486, 'protein' => 16.5, 'fat' => 30.7, 'carbohydrates' => 42.1, 'sodium' => 16, 'fiber' => 34.4],


        ];
        $products = Product::all();
        self::render('Продукти', 'admin/products', 'admin', [
            'products' => $products
        ]);
    }

    public function search($params){
        $search_text=$params['text'];
        $data=DB::selectByQuery("SELECT id,title FROM products WHERE title LIKE '{$search_text}%' ORDER BY title LIMIT 5;");
        echo json_encode([
            'status'=>1,
            'data'=>$data
        ]);
    }
    public function create()
    {
        self::render('Додати продукт', 'profile_form/product');
    }
    public function addbyadmin()
    {
        self::render('Додати продукт', 'admin_form/product', 'admin');
    }
    
    public function edit()
    {
        self::render('Редагувати продукт', 'profile_form/product_edit', 'main', [
            'product' => Product::find($_GET['id'])
        ]);
    }
    public function editbyadmin()
    {
        self::render('Редагувати продукт', 'admin_form/product_edit', 'admin', [
            'product' => Product::find($_GET['id'])
        ]);
    }

    public function storeproductbyadmin($request)
    {
        Data::pa($request);
        Product::create([
            "title" => $request['title'],
            "type" => isset($request['is_can_be_meal']) ? ($request['is_can_be_meal'] == "on" ? 'product' : 'ingredient') : 'ingredient',
            "kcal" => $request['kcal'],
            "fat" => $request['fat'],
            "protein" => $request['protein'],
            "carbonation" => $request['carbonation'],
            "na" => $request['na'],
            "cellulose" => $request['cellulose'],
        ]);
        $product_id = DB::lastInsertId();
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
        Router::redirect('/admin/products');
    }
    public function deleteproductbyadmin($id)
    {
        DB::delete('meals', condition: "product_id=" . $id);
        DB::delete('products_in_recipes', condition: "product_id=" . $id);
        DB::delete('product_in_diets', condition: "product_id=" . $id);
        DB::delete('allergies_on_products', condition: "product_id=" . $id);
        DB::delete('liked_products', condition: "product_id=" . $id);
        Product::delete("id=" . $id);
        // Router::redirect('/admin/products');
    }
    public function deleteproduct($id)
    {
        DB::delete('meals', condition: "product_id=" . $id);
        DB::delete('products_in_recipes', condition: "product_id=" . $id);
        DB::delete('product_in_diets', condition: "product_id=" . $id);
        DB::delete('allergies_on_products', condition: "product_id=" . $id);
        DB::delete('liked_products', condition: "product_id=" . $id);
        Product::delete("id=" . $id);
        // Router::redirect('/profile/products');
    }
}
