<?php

namespace App\Controllers;

use App\DB;
use App\Models\Meal;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Workout;
use App\Router;
use App\Data;
use App\Services\MealService;
use App\Services\MenuGenerateService;
use App\Services\MenuService;
use App\Services\TrainingService;
use App\Services\UserService;
use App\Services\WeightService;

class MealController extends Controller
{

    public function calendar($params)
    {

        $month = $params['m'] ?? date('m');
        $year = $params['y'] ?? date('Y');
        $days_in_month = date("t", mktime(0, 0, 0, $month, 1, $year));

        $day_of_week = date('w', timestamp: strtotime($year . '-' . $month . '-01'));


        $next_year = $month == '12' ? $year - 1 : $year;
        $next_month = $month == '12' ? '01' : $month + 1;
        $prev_year = $month == '01' ? $year + 1 : $year;
        $prev_month = $month == '01' ? '12' : $month - 1;

        $next_month = $next_month < 10 ? '0' . $next_month : $next_month;
        $prev_month = $prev_month < 10 ? '0' . $prev_month : $prev_month;

        $dates = [];
        $add_empty_days = null;
        if ($day_of_week == 0)
            $add_empty_days = 6;
        else if ($day_of_week == 1)
            $add_empty_days = 0;
        else
            $add_empty_days = $day_of_week - 1;
        for ($i = 0; $i < $add_empty_days; $i++) {
            array_push($dates, [
                'date' => 0,
            ]);
        }
        for ($i = 1; $i <= $days_in_month; $i++) {
            $d=$i>9?$i:'0'.$i;
            $menu = MealService::bydate($year . '-' . $month . '-' . $d);
            // $trainings=TrainingService::bydate($year.'-'.$month.'-'.$i);

            array_push($dates, [
                'date' => $i,
                'full_date' => $year . '-' . $month . '-' . $d,
                'is_current_date' => date('d') == $d ? true : false,
                'menu' => $menu,
                // 'trainings' => $trainings,
            ]);
        }

        for ($i = 0; $i < (7 - (($add_empty_days + $days_in_month) % 7)); $i++) {
            array_push($dates, [
                'date' => 0,
            ]);
        }

        self::render('Календар', 'profile/calendar', 'main', [
            'month' => $month,
            'user' => new User(User::id()),
            'year' => $year,
            'next_year' => $next_year,
            'next_month' => $next_month,
            'prev_year' => $prev_year,
            'prev_month' => $prev_month,
            'days_in_month' => $days_in_month,
            'dates' => $dates,
        ]);
    }
    public function day($params)
    {
        $date = $params['date'];
        $date_text = date("d", strtotime($date)) . ' (' . Data::$week_days_ua[date("w", strtotime($date))] . ') ' . Data::$months_ua[date("m", strtotime($date))] . ' ' . date("Y", strtotime($date));
        $user = new User(User::id());

        $trainings = TrainingService::bydate($date);
        $menu = MenuService::menu($date);
        $weight = WeightService::bydate($date);
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

        self::render('Перегляд календаря', 'profile/day', 'main', [
            'user' => $user,
            'date_text' => $date_text,
            'date' => $date,
            'weigth' => $weight,
            'trainings' => $trainings['trainings'],
            'menu' => $menu,
            'norms' => $norms,
            'workoutsTypes' => Workout::all(),
            'mealtimes' => Data::$mealtimes,
            'user_norms' => UserService::norms()
        ]);
    }
    public function APIstoremealtoday($request)
    {
        try {
            $res = Meal::create([
                "user_id" => User::id(),
                "recipe_id" => $request['recipe_id'],
                "product_id" => $request['product_id'],
                "weigth" => $request['weigth'],
                "date" => Data::today(),
                "time" => $request['time'],
            ]);
            echo json_encode([
                'status' => 1,
                'message' => $res,
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 0,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function generatemenu($request)
    {
        $from_main_page = false;
        $date_start = $request['date_start'] ?? null;
        $date_end = $request['date_end'] ?? null;
        $dates = [];
        if (is_null($date_start)||is_null($date_end)) {
            $dates = [Data::today()];
            $from_main_page = true;
        } else {
            $current_date=$date_start;
            while ($current_date!=$date_end) {
                array_push($dates,$current_date);
                $current_date=date('Y-m-d', strtotime('+1 day', strtotime($current_date)));
            }
            array_push($dates,$date_end);
        }
        //generate menu
        $generate_menu = new MenuGenerateService();
        $generate_menu->run($request, $dates);

        // //CLEAR menu
        DB::delete('meals', 'date IN ("' . implode('", "', $dates) . '") AND user_id=' . User::id());
        $res=$generate_menu->saveToDB();
        // Data::dd($res);

        if ($from_main_page)
            Router::redirect('/profile');
        else
            Router::redirect('/profile/calendar');
    }

    public function APIsearch($param)
    {
        //TODO 5 recipes and 5 products
        // filter by diets and allergies, prioritets on liked,
        try {
            $search = urldecode($param['search']);
            //search recipes
            $recipes = DB::selectByQuery("SELECT * FROM recipes WHERE title LIKE '%$search%' ORDER BY title LIMIT 5;");
            //search products
            $products = DB::selectByQuery("SELECT * FROM products WHERE title LIKE '%$search%' ORDER BY title LIMIT 5;");
            $searched = [];
            foreach ($recipes as $recipe) {
                $recipe_full = new Recipe($recipe);
                array_push($searched, [
                    "id" => $recipe["id"],
                    "title" => $recipe["title"],
                    "type" => "r",
                    "full_data" => [
                        "kcal" => $recipe_full->kcal,
                        "protein" => $recipe_full->protein,
                        "fat" => $recipe_full->fat,
                        "carbonation" => $recipe_full->carbonation,
                        "na" => $recipe_full->na,
                        "cellulose" => $recipe_full->cellulose,
                        "ingredients" => $recipe_full->ingredients
                    ]

                ]);
            }
            foreach ($products as $product) {
                array_push($searched, [
                    "id" => $product["id"],
                    "title" => $product["title"],
                    "type" => "p",
                    "full_data" => [
                        "kcal" => $product['kcal'],
                        "protein" => $product['protein'],
                        "fat" => $product['fat'],
                        "carbonation" => $product['carbonation'],
                        "na" => $product['na'],
                        "cellulose" => $product['cellulose'],
                        "ingredients" => []
                    ]
                ]);
            }
            echo json_encode([
                'status' => 1,
                'message' => '', //
                'data' => $searched

            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 0,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
