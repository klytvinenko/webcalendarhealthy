<?php

namespace App;

use App\Models\Recipe;

class Validate
{
    public static function validate($page, $array)
    {
        try {
            $is_valid = static::{$page}($array);
            if ($is_valid == false) {
                header('Location: ' . str_replace("http://localhost:8080", "", $_SERVER['HTTP_REFERER']));
            }
        } catch (\Error $e) {
            echo $e->getMessage();
            echo "<br>";
            echo $e->getTraceAsString();
            exit();
        }
    }
    public static function signin($array)
    {
        $is_valid = true;

        $login = $array['login'];
        $password = $array['password'];

        if (empty($login) && empty($password)) {
            $_SESSION['message']['all_form'] = '* Заповніть всі поля';
            $_SESSION['not_valid']['login'] = true;
            $_SESSION['not_valid']['password'] = true;
            $is_valid = false;
        } else if (empty($login) && !empty($password)) {
            $_SESSION['message']['login'] = 'Введіть логін';
            $_SESSION['not_valid']['login'] = true;
            $is_valid = false;
        } else if (!empty($login) && empty($password)) {
            $_SESSION['message']['password'] = 'Введіть пароль';
            $_SESSION['not_valid']['password'] = true;
            $is_valid = false;
        } else {
            $is_valid = true;
        }

        return $is_valid;
    }
    public static function signup($array)
    {
        $is_valid = true;

        $login = $array['login'];
        $password = $array['password'];
        $password_confirm = $array['password_confirm'];
        $email = $array['email'];

        if (empty($login) && empty($email) && empty($password) && empty($password_confirm)) {
            $_SESSION['message']['all_form'] = '* Заповніть всі поля';

            $is_valid = false;
        }
        if (empty($login)) {
            $_SESSION['message']['login'] = 'Введіть логін';
            $_SESSION['not_valid']['login'] = true;
            $is_valid = false;
        }
        if (empty($email)) {
            $_SESSION['message']['email'] = 'Введіть ел.пошту';
            $_SESSION['not_valid']['email'] = true;
            $is_valid = false;
        }
        if (empty($password)) {
            $_SESSION['message']['password'] = 'Введіть пароль';
            $_SESSION['not_valid']['password'] = true;
            $is_valid = false;
        }
        if (empty($password_confirm)) {
            $_SESSION['message']['password_confirm'] = 'Введіть підвтердження пароля';
            $_SESSION['not_valid']['password_confirm'] = true;
            $is_valid = false;
        }

        if (strlen($password) < 6) {
            $_SESSION['message']['password'] = 'Пароль повинен містити не менше 6 символів';
            $_SESSION['not_valid']['password'] = true;
            $is_valid = false;
        } else if ($password != $password_confirm) {
            $_SESSION['message']['password'] = 'Паролі не співпадають';
            $_SESSION['not_valid']['password'] = true;
            $is_valid = false;
        }
        $email_data = DB::selectOne('users', '*', "email='$email'");
        if (!is_null($email_data)) {
            $_SESSION['message']['email'] = 'Ел.пошта вже використовується';
            $_SESSION['not_valid']['email'] = true;
            $is_valid = false;
        }
        $login_data = DB::selectOne('users', '*', "login='$login'");
        if (!is_null($login_data)) {
            $_SESSION['message']['login'] = 'Логін вже використовується';
            $_SESSION['not_valid']['login'] = true;
            $is_valid = false;
        }


        return $is_valid;
    }
    public static function storeworkoutbyadmin($array)
    {
        $is_valid = true;

        $title = $array['title'];
        $description = $array['description'];
        $kcal = $array['kcal'];

        if (empty($title) && empty($kcal)) {
            $_SESSION['message']['all_form'] = '* Заповніть всі поля';
            $_SESSION['not_valid']['title'] = true;
            $_SESSION['not_valid']['kcal'] = true;
            $is_valid = false;
        } else if (empty($title)) {
            $_SESSION['message']['title'] = 'Введіть назву';
            $_SESSION['not_valid']['title'] = true;
            $is_valid = false;
        } else if (empty($kcal)) {
            $_SESSION['message']['kcal'] = 'Введіть витрати калорій';
            $_SESSION['not_valid']['kcal'] = true;
            $is_valid = false;
        } else {
            $is_valid = true;
        }
        if (!$is_valid) {

            $_SESSION['old_values']['title'] = $title;
            $_SESSION['old_values']['description'] = $description;
            $_SESSION['old_values']['kcal'] = $kcal;
        }


        return $is_valid;
    }
    public static function APIstoremealtoday($array)
    {
        $is_valid = true;

        return $is_valid;
    }
    public static function storedietbyadmin($array)
    {
        $is_valid = true;

        $title = $array['title'];
        $description = $array['description'];

        if (empty($title)) {
            $_SESSION['message']['title'] = 'Введіть назву';
            $_SESSION['not_valid']['title'] = true;
            $_SESSION['old_values']['title'] = $title;
            $_SESSION['old_values']['description'] = $description;
            $is_valid = false;
        } else {
            $is_valid = true;
        }

        return $is_valid;
    }
    public static function storeallergybyadmin($array)
    {
        $is_valid = true;

        $title = $array['title'];

        if (empty($title)) {
            $_SESSION['message']['title'] = 'Введіть назву';
            $_SESSION['not_valid']['title'] = true;
            $_SESSION['old_values']['title'] = $title;
            $is_valid = false;
        } else {
            $is_valid = true;
        }

        return $is_valid;
    }
    public static function storerecipebyadmin($request)
    {
        $is_valid = true;
        $ingredients = $request['ingredients'];
        $title = $request['title'];
        $type = $request['type'];
        $description = $request['description'];
        $diets = $request['diets'];
        $ingredients = $request['ingredients'];
        $ingredients_weigths = $request['ingredients_weigths'];
        if (empty($ingredients)) {
            $_SESSION['message']['ingredients'] = 'У рецепт не додано інгредієнтів!';
            $_SESSION['not_valid']['ingredients'] = true;
            $_SESSION['old_values']['title'] = $title;
            $_SESSION['old_values']['type'] = $type;
            $_SESSION['old_values']['diets'] = $diets;
            $_SESSION['old_values']['description'] = $description;
            $_SESSION['old_values']['ingredients'] = $ingredients;
            $_SESSION['old_values']['ingredients_weigths'] = $ingredients_weigths;
            $is_valid = false;
        }
        return $is_valid;
    }
    public static function storeproductbyadmin($request)
    {
        $is_valid = true;
        return $is_valid;
    }
    public static function updaterecipebyadmin($request)
    {
        return self::storerecipebyadmin($request);
    }
    public static function updateproductbyadmin($request)
    {
        return self::storeproductbyadmin($request);
    }
    public static function updateworkoutbyadmin($request)
    {
        return self::storeworkoutbyadmin($request);
    }

    public static function updatedietbyadmin($request)
    {
        return self::storedietbyadmin($request);
    }
    public static function updateallergybyadmin($request)
    {
        return self::storeallergybyadmin($request);
    }
    public static function changediet($request)
    {

        $is_valid = true;
        return $is_valid;
    }
    public static function generatemenu($request)
    {

        $is_valid = true;
        return $is_valid;
    }
    public static function calckcal($request)
    {

        $is_valid = true;
        return $is_valid;
    }

    public static function storeproduct($request)
    {
        $is_valid = true;
        return $is_valid;
    }

    public static function storerecipe($request)
    {
        $is_valid = true;
        return $is_valid;
    }

    public static function storeworkout($request)
    {
        $is_valid = true;
        return $is_valid;
    }
    public static function storeweigth($request)
    {
        $is_valid = true;
        return $is_valid;
    }
    public static function APIstore($request)
    {
        $is_valid = true;
        return $is_valid;
    }
    public static function updateworkout($request)
    {
        $is_valid = true;
        return $is_valid;
    }
    public static function updaterecipe($request)
    {
        $is_valid = true;
        return $is_valid;
    }
}
