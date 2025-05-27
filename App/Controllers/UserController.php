<?php

namespace App\Controllers;

use App\Data;
use App\DB;
use App\Services\AuthService;
use App\Services\UserService;
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
        $user = new User(User::id());
        $trainings = TrainingService::today();
        $menu = MenuService::menu();
        $weight = WeightService::today();
        $norms = [
            'kcal' => 0,
            'protein' => 0,
            'fat' => 0,
            'carbonation' => 0,
            'na' => 0,
            'cellulose' => 0,
        ];
        if ($menu['sums'][5]['kcal'] != 0) {
            $new_kcal = $menu['sums'][5]['kcal'] + $trainings['kcal'];
            $coef = (($new_kcal * 100) / $menu['sums'][5]['kcal']) / 100;
            $norms = [
                'kcal' => $new_kcal,
                'protein' => $norms['protein'] * $coef,
                'fat' => $norms['fat'] * $coef,
                'carbonation' => $norms['carbonation'] * $coef,
                'na' => $norms['na'] * $coef,
                'cellulose' => $norms['cellulose'] * $coef,
            ];
        }
        
        self::render('Головна', 'profile/index', 'main', [
            'user' => $user,
            'date' => date("d") . ' (' . Data::$week_days_ua[date("w")] . ') ' . Data::$months_ua[date("m")] . ' ' . date("Y"),
            'weigth' => $weight,
            'trainings' => $trainings['trainings'],
            'menu' => $menu,
            'norms' => $norms,
            'workoutsTypes' => Workout::all(),
            'mealtimes'=>Data::$mealtimes,
            'user_norms'=>UserService::norms()

        ]);
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
        $user = new User(User::id());
        $activity_levels = [
            ['id' => '1.2', 'title' => '1.2 - сидячий спосіб життя'],
            ['id' => '1.375', 'title' => '1.375 - легка активність'],
            ['id' => '1.55', 'title' => '1.55 - помірна активність'],
            ['id' => '1.725', 'title' => '1.725 - висока активність'],
            ['id' => '1.9', 'title' => '1.9 - дуже висока активність'],
        ];
        for ($i = 0; $i < count($activity_levels); $i++) {
            if ($user->activity_level == $activity_levels[$i]['id'])
                $activity_levels[$i]['checked'] = true;
        }
        self::render('Розрахування норми калорій', 'profile_form/calc_kcal', 'main', [
            'activity_levels' => $activity_levels,
            'user' => $user
        ]);

    }
    public function calckcal($request)
    {

        $user = new User(User::id());
        $user->sex = $request['sex'];
        $weight = $request['weight'];
        $user->height = $request['height'];
        $user->activity_level = floatval($request['activity_level']);
        $user->date_of_birth = $request['date_of_birth'];
        $user->update_age();
        $user->calcNorms($weight);

        Router::redirect('/profile/setting');

    }
}
