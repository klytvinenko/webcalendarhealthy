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
        $item_on_page = 10;
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
        $item_on_page = 10;
        $products = Product::pagination($item_on_page,true);
        $products_res=[];
        foreach ($products as $product) {
            $products_res[]=new Product($product['id']);
        }
        self::render('Продукти', 'admin/products', 'admin', [
            'products' => $products_res,
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
        ProductService::create($request);
        Router::redirect('/profile/products');
    }

    public function storeproductbyadmin($request)
    {
        ProductService::create($request,true);
        Router::redirect('/admin/products');
    }
    
    public function updateproduct($params, $request)
    {
        ProductService::create($request);
        Router::redirect('/profile/products');
    }

    public function updateproductbyadmin($params, $request)
    {
        ProductService::update($params['id'],$request);
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
        ProductService::delete($id);
    }

    public function deleteproduct($id)
    {
        ProductService::delete($id);
    }
}
