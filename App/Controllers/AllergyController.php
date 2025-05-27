<?php

namespace App\Controllers;

use App\DB;
use App\Models\Allergy;
use App\Router;
use App\Data;

class AllergyController extends Controller
{
    public function addlistbyadmin($params)
    {
        $id=$params['id'];
        $allergy=new Allergy($id);
        self::render('Додавання продуктів', 'profile_form/allergy_add_list', 'main', [
            'allergy' => $allergy,
        ]);
    }
    public function storelistbbyadmin()
    {
        self::render('Редагувати продукт', 'profile_form/product_edit', 'main', [
            'product' => Product::find($_GET['id'])
        ]);
    }
    public function addbyadmin()
    {
        self::render('Додавання алергену', 'admin_form/allergy', 'admin');
    }

    public function editbyadmin($params)
    {
        $id = $params['id'];
        $allergy = new Allergy($id);
        self::render($allergy->name, 'admin_form/allergy_edit', 'admin', ['allergy' => $allergy]);
    }
    public function updateallergybyadmin($params,$request)
    {   
        $id=$params['id'];
        Allergy::update('id='.$id,[
            "name" => $request['title'],
        ]);
        Router::redirect('/admin/diet');
    }
    public function storeallergybyadmin($request)
    {
        Allergy::create([
            "name" => $request['title'],
        ]);
        Router::redirect('/admin/diet');
    }
    public function deleteallergybyadmin($id)
    {
        DB::delete('users_allergies', "allergy_id=" . $id);
        DB::delete('allergies_on_products', "allergy_id=" . $id);
        Allergy::delete("id=" . $id);
        // Router::redirect('/admin/diet');
    }
    public function deleteaallergy($id)
    {
        DB::delete('users_allergies', "allergy_id=" . $id);
        DB::delete('allergies_on_products', "allergy_id=" . $id);
        Allergy::delete("id=" . $id);
        // Router::redirect('/profile/diet');
    }
}
