<?php

namespace App\Controllers;

use App\Data;
use App\DB;
use App\Models\Allergy;
use App\Models\Diet;
use App\Models\Product;
use App\Models\User;
use App\Router;
use App\Services\ProductService;
class ProductController extends Controller
{
    public function index()
    {
        $item_on_page = 15;
        $products = Product::pagination($item_on_page);
        for ($i = 0; $i < count($products); $i++) {
            $products[$i]['is_liked'] = ProductService::isLiked($products[$i]['id']);
        }
        self::render('Продукти', 'profile/products', 'main', [
            'user' => new User(User::id()),
            'products' => $products,
            'item_on_page' => $item_on_page
        ]);
    }
    public function indexbyadmin()
    {
        $item_on_page = 15;
        $products = Product::pagination($item_on_page);
        self::render('Продукти', 'admin/products', 'admin', [
            'products' => $products,
            'item_on_page' => $item_on_page
        ]);
    }

    public function show($params)
    {
        $id = $params['id'];
        $product = new Product($id);
        self::render("Перегляд продукту", 'profile/product', 'main', [
            'product' => $product
        ]);
    }
    public function showbyadmin($params)
    {
        $id = $params['id'];
        $product = new Product($id);
        self::render($product->title, 'admin/product', 'admin', [
            'product' => $product
        ]);
    }
    public function search($params)
    {
        $search_text = urldecode($params['text']);

        $data = DB::selectByQuery("SELECT id,title FROM products WHERE title LIKE '{$search_text}%' LIMIT 10;");
        echo json_encode([
            'status' => 1,
            'data' => $data,
            'w' => $search_text
        ]);
    }
    public function add()
    {
        $diets = Diet::all();
        $allergies = Allergy::all();
        self::render('Додати продукт', 'profile_form/product', 'main', [
            'allergies' => $allergies,
            'diets' => $diets,
        ]);
    }

    public function addbyadmin()
    {
        $diets = Diet::all();
        $allergies = Allergy::all();
        self::render('Додати продукт', 'admin_form/product', 'admin');
    }
    public function edit($params)
    {
        $id = $params['id'];
        $product = new Product($id);

        $diet_ids = array_column($product->dietsFull(), 'id');
        $diets = Diet::all();
        for ($i = 0; $i < count($diets); $i++) {
            if (in_array($diets[$i]['id'], $diet_ids))
                $diets[$i]['checked'] = true;
        }
        $allergy_ids = array_column($product->allergiesFull(), 'id');
        $allergies = Allergy::all();
        for ($i = 0; $i < count($allergies); $i++) {
            if (in_array($allergies[$i]['id'], $allergy_ids))
                $allergies[$i]['checked'] = true;
        }
        self::render($product->title, 'profile_form/product_edit', 'main', [
            'product' => $product,
            'diets' => $diets,
            'allergies' => $allergies,

        ]);
    }
    public function editbyadmin($params)
    {
        $id = $params['id'];
        $product = new Product($id);

        $diet_ids = array_column($product->dietsFull(), 'id');
        $diets = Diet::all();
        for ($i = 0; $i < count($diets); $i++) {
            if (in_array($diets[$i]['id'], $diet_ids))
                $diets[$i]['checked'] = true;
        }
        $allergy_ids = array_column($product->allergiesFull(), 'id');
        $allergies = Allergy::all();
        for ($i = 0; $i < count($allergies); $i++) {
            if (in_array($allergies[$i]['id'], $allergy_ids))
                $allergies[$i]['checked'] = true;
        }
        self::render($product->title, 'admin_form/product_edit', 'admin', [
            'product' => $product,
            'diets' => $diets,
            'allergies' => $allergies,

        ]);
    }

    public function storeproduct($request)
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
        Router::redirect('/profile/products');
    }
    public function storeproductbyadmin($request)
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
        Router::redirect('/admin/products');
    }
    
    public function updateproduct($params, $request)
    {
        $id = $params['id'];
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
        Router::redirect('/profile/products');
    }
    public function updateproductbyadmin($params, $request)
    {
        $id = $params['id'];
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
        Router::redirect('/admin/products');
    }
    public function like($params)
    {
        $product_id = $params['id'];
        //is liked
        $res = DB::selectOne('liked_products', '*', 'user_id=' . User::id() . ' AND product_id=' . $product_id);
        if (is_null($res)) {
            //if no - add
            DB::insert('liked_products', [
                'user_id' => User::id(),
                'product_id' => $product_id,
            ]);
        } else {
            //if yes - remove
            DB::delete('liked_products', 'user_id=' . User::id() . ' AND product_id=' . $product_id);
        }
        Router::redirect('/profile/products');
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
