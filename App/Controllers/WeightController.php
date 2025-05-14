<?php

namespace App\Controllers;

use App\Models\Weight;
use App\Router;
use App\Data;

class WeightController extends Controller
{
    public function APIstore($request)
    {
        //TODO: create triger in DB
        Weight::create([
            "weight" => $request['weight'],
            "date" => Data::today(),
            "user_id" => $_SESSION['user']['id']
        ]);
        Router::redirect('/profile');
    }
}
