<?php

namespace App\Controllers;

use App\Data;
use App\DB;
use App\Services\AuthService;
use App\UserType;
use App\Validate;
use App\Models\User;
use App\Models\Workout;
use App\Services\TrainingService;
use App\Services\WeightService;
use App\Router;
use App\Services\MenuService;
class UserController extends Controller
{

    public function login()
    {
        self::render('Вхід', 'auth/signin', 'auth');
    }
    public function register()
    {
        self::render('Реєстрація', 'auth/register', 'auth');
    }
    public function signin($request)
    {

        $user = AuthService::findUser($request['login'], $request['password']);
        if (!is_null($user)) {
            echo 4;
            $type = $user['login'] == "Admin" ? UserType::ADMIN : UserType::LOGINED;
            $_SESSION['user'] = [
                "id" => $user['id'],
                "login" => $user['login'],
                "email" => $user['email'],
                "norms" => (array) json_decode($user['norms']),
                "type" => $type->value
            ];
            if ($type == UserType::ADMIN) {
                Router::redirect('/admin');
            } else {
                Router::redirect('/profile');
            }
        } else {
            if (AuthService::checkLogin($request['login'])) {
                $_SESSION['message']['auth'] = 'Пароль не вірний';
                echo "password in db:" . AuthService::checkLogin($request['login'])['password'];
                echo "<br>";
                echo "password:" . md5($request['password']);
            } else
                $_SESSION['message']['auth'] = 'Логін або пароль не вірний';
            Router::redirect('/');
        }
    }
    public function signup($request)
    {
        Validate::signup(array: $request);

        AuthService::register($request['login'], $request['password'], $request['email']);
        $_SESSION['message']['registered'] = 'Ви успішно зареєструвалися';

        Router::redirect('/');
    }

    public function logout()
    {
        unset($_SESSION['user']);
        Router::redirect('/');
    }


    public function profile()
    {
        $trainings = TrainingService::today();
        $menu = MenuService::menu(Data::today());
        $weight = WeightService::today();

        $new_kcal = $menu['norms'] + $trainings['kcal'];
        $coef = (($new_kcal * 100) / $menu['norms']) / 100;
        $norms = [
            'kcal' => $new_kcal,
            'protein' => $menu['protein'] * $coef,
            'fat' => $menu['fat'] * $coef,
            'carbonation' => $menu['carbonation'] * $coef,
            'na' => $menu['na'] * $coef,
            'cellulose' => $menu['cellulose'] * $coef,
        ];

        $data = [
            'user' => $_SESSION['user'],
            'date' => date("d") . ' (' . Data::$week_days_ua[date("w")] . ') ' . Data::$months_ua[date("m")] . ' ' . date("Y"),
            'trainings' => $trainings['training'],
            'menu' => $menu['text'],
            'weight' => $weight,
            'norms' => $norms

        ];
        self::render('Головна', 'profile/index', 'main', $data);
    }
    public function setting()
    {
        $user = new User(User::id());
        self::render('Налаштування', 'profile/setting', 'main', [
            'user' => $user,
        ]);
    }
    public function indexbyadmin()
    {
        self::render('Головна', 'admin/index', 'admin');
    }
    public function usernorms()
    {
        $activity_levels = [
            '1.2' => 'сидячий спосіб життя',
            '1,375' => 'легка активність',
            '1.55' => 'помірна активність',
            '1,725' => 'висока активність',
            '1,9' => 'дуже висока активність',
        ];
        self::render('Головна', 'profile_form/calc_kcal', 'main', [
            'activity_levels' => $activity_levels,
        ]);

    }
    public function calckcal($request)
    {

        $user = new User(User::id());
        $user->sex = $request['sex'];
        $user->weight = $request['weight'];
        $user->height = $request['height'];
        $user->activity_level = $request['activity_level'];
        $user->date_of_birth = $request['date_of_birth'];
        $user->update_age();
        echo $user->age;
        $user->calcNorms();

        Router::redirect('/profile/setting');

    }
}
