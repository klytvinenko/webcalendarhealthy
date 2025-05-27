<?php

namespace App\Services;

use App\DB;

class AuthService
{
    public static function findUser($login, $password)
    {
        $password = md5($password);
        return DB::selectOne('users', '*', "login='$login' AND password='$password'");
    }
    public static function checkLogin($login)
    {
        return DB::selectOne('users', '*', "login='$login';");
    }

    public static function register($login, $password, $email)
    {
        $password = md5($password);
        $res=DB::insert('users', [
            'login' => $login,
            'password' => $password,
            'email' => $email,
            'norms' => json_encode(
                $norms = [
                    "kcal" => 0,
                    "protein" => 0,
                    "fats" => 0,
                    "carbohydrates" => 0,
                    "na" => 0,
                    "cellulose" => 0,
                    "diets" => [],
                    "allergies" => []
                ]
            )
        ]);
        return $res;
    }
}
