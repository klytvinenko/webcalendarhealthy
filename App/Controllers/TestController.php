<?php

namespace App\Controllers;

class TestController extends Controller
{
    public function forms()
    {
        self::render('Форми', 'test/forms', 'test');
    }

}
