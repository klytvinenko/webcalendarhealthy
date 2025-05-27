<?php

namespace App\Services;

use App\Models\Meal;

class MenuService
{
    public static function menu($date = null)
    {
        $meals_today = [];
        if ($date == null)
            $meals_today = Meal::today();
        else
            $meals_today = Meal::bydate($date);
        $sums = [
            'kcal' => 0,
            'fat' => 0,
            'protein' => 0,
            'carbonation' => 0,
            'na' => 0,
            'cellulose' => 0,
        ];
        foreach ($meals_today as $meal) {
            $sums['kcal'] += $meal->kcal;
            $sums['fat'] += $meal->fat;
            $sums['protein'] += $meal->protein;
            $sums['carbonation'] += $meal->carbonation;
            $sums['na'] += $meal->na;
            $sums['cellulose'] += $meal->cellulose;
        }
        $meals_by_time = [[],[],[],[],[]];
        foreach ($meals_today as $meal) {
            if ($meal->time == 'breakfast')
                array_push($meals_by_time[0], $meal);
            else if ($meal->time == 'snack 2')
                array_push($meals_by_time[1], $meal);
            else if ($meal->time == 'lunch')
                array_push($meals_by_time[2], $meal);
            else if ($meal->time == 'snack 3')
                array_push($meals_by_time[3], $meal);
            else if ($meal->time == 'dinner')
                array_push($meals_by_time[4], $meal);
        }
        $sums_by_time = [];
        foreach ($meals_by_time as $meals_by_time_) {
            $sum_ = [
                'kcal' => 0,
                'fat' => 0,
                'protein' => 0,
                'carbonation' => 0,
                'na' => 0,
                'cellulose' => 0,
            ];
            foreach ($meals_by_time_ as $item) {

                $sum_['kcal'] += $item->kcal;
                $sum_['fat'] += $item->fat;
                $sum_['protein'] += $item->protein;
                $sum_['carbonation'] += $item->carbonation;
                $sum_['na'] += $item->na;
                $sum_['cellulose'] += $item->cellulose;
            }
            array_push($sums_by_time, $sum_);
        }
        $sums_by_time[5] = $sums;
        return [
            "data" => $meals_today,
            "by_time" => $meals_by_time,
            "sums" => $sums_by_time,
        ];
    }
    public static function generateMenuOnDay($date)
    {
        //todo
        return [
            "data" => null,
            "text" => null
        ];
    }
    public static function generateMenu($date_start, $date_end, $with_favorites)
    {
        //todo
        $datacheck_recipes = Data::select("recipes", limit: "1");
        $datacheck_products = Data::select("products", limit: "1");
        if (count($datacheck_recipes) == 0 && count($datacheck_products) == 0) {
            return [
                "text" => "Вам потрібно заповнити базу даних рецептами та продуктами",
                'data' => null,
            ];
        }
        //generate menu
        $today = date("Y-m-d");
        //norms
        $norms = $_SESSION['user']['norms'];
        $diets = $_SESSION['user']['norms']['diets'];
        $allergies = $_SESSION['user']['norms']['allergies'];
        //data fpr generating
        $recipes_maindishes = Data::selectByQuery("SELECT r.* FROM recipes AS r JOIN recipe_in_diets AS rid ON rid.recipe_id=R.id JOIN diets AS d ON d.id=rid.diet_id JOIN products_in_recipes AS pir ON pir.recipe_id=r.id JOIN allergies_on_products AS aop ON pir.product_id=aop.product_id JOIN allergies AS a ON a.id=aop.allergy_id WHERE d.id IN(" . implode(",", $diets) . ") AND a.id NOT IN (" . implode(",", $allergies) . ") AND r.type='maindish' GROUP BY r.id;");
        $recipes_other = Data::selectByQuery("SELECT r.* FROM recipes AS r JOIN recipe_in_diets AS rid ON rid.recipe_id=R.id JOIN diets AS d ON d.id=rid.diet_id JOIN products_in_recipes AS pir ON pir.recipe_id=r.id JOIN allergies_on_products AS aop ON pir.product_id=aop.product_id JOIN allergies AS a ON a.id=aop.allergy_id WHERE d.id IN(" . implode(",", $diets) . ") AND a.id NOT IN (" . implode(",", $allergies) . ") AND r.type!='maindish' GROUP BY r.id;");
        $products = Data::selectByQuery("SELECT p.* FROM products AS p JOIN product_in_diets AS pir ON pir.product_id=p.id JOIN allergies_on_products AS aop ON aop.product_id=p.id WHERE pir.diet_id IN (" . implode(",", $diets) . ") AND aop.allergy_id NOT IN (" . implode(",", $allergies) . ") AND p.type!='ingredient' GROUP BY p.id;");

        if (count($recipes_maindishes) == 0 || count($products) == 0 || count($recipes_other) == 0) {
            return [
                "text" => "You need to fill the database with recipes and products for all diets and allergens",
                'data' => null,
            ];
        }
        //array for meals
        $mealtimes = [
            [
                "title" => "Сніданок",
                "procent" => ["min" => 25, "max" => 25],
                "meals" => [],
                "filled" => false
            ],
            [
                "title" => "Ранковий перекус",
                "procent" => ["min" => 5, "max" => 10],
                "meals" => [],
                "filled" => false
            ],
            [
                "title" => "Обід",
                "procent" => ["min" => 40, "max" => 45],
                "meals" => [],
                "filled" => false
            ],
            [
                "title" => "Після обідній перекус",
                "procent" => ["min" => 10, "max" => 15],
                "meals" => [],
                "filled" => false
            ],
            [
                "title" => "Вечеря",
                "procent" => ["min" => 15, "max" => 20],
                "meals" => [],
                "filled" => false
            ]
        ];
        //for breakfast, lunch and dinner
        array_push($mealtimes[0]['meals'], Recipe::find(self::randElem($recipes_maindishes)['id']));
        array_push($mealtimes[2]['meals'], Recipe::find(self::randElem($recipes_maindishes)['id']));
        array_push($mealtimes[4]['meals'], Recipe::find(self::randElem($recipes_maindishes)['id']));
        //for first and second meal
        $mealtimes[0]['kcal'] = $mealtimes[0]['meals'][0]['kcal'];
        $mealtimes[2]['kcal'] = $mealtimes[2]['meals'][0]['kcal'];
        $mealtimes[4]['kcal'] = $mealtimes[4]['meals'][0]['kcal'];

        //for snacks
        //for first snack
        if (randBool()) {
            $product_for_snack = self::randElem($products);
            array_push($mealtimes[1]['meals'], ['product' => $product_for_snack, 'weigth' => $product_for_snack['weigth_for_unit']]);
            $mealtimes[1]['kcal'] = ($product_for_snack['kcal'] * $product_for_snack['weigth_for_unit']) / 100;
        } else {
            array_push($mealtimes[1]['meals'], Recipe::find(self::randElem($recipes_other)['id']));
            $mealtimes[1]['kcal'] = $mealtimes[1]['meals'][0]['kcal'];
        }
        //for second snack
        if (randBool()) {
            $product_for_snack = self::randElem($products);
            array_push($mealtimes[3]['meals'], ['product' => $product_for_snack, 'weigth' => $product_for_snack['weigth_for_unit']]);
            $mealtimes[3]['kcal'] = ($product_for_snack['kcal'] * $product_for_snack['weigth_for_unit']) / 100;
        } else {
            array_push($mealtimes[3]['meals'], Recipe::find(self::randElem($recipes_other)['id']));
            $mealtimes[3]['kcal'] = $mealtimes[3]['meals'][0]['kcal'];

        }
        //fill other kcal
        $index = 0;
        while (!$mealtimes[0]['filled'] || !$mealtimes[1]['filled'] || !$mealtimes[2]['filled'] || !$mealtimes[3]['filled'] || !$mealtimes[4]['filled']) {
            $mealtime = $mealtimes[$index];
            if ($mealtime['filled'] == false) {
                $choosed_meal_or_product = null;
                $is_can_be_maindish = false;
                if ($index == 0 || $index == 2 || $index == 4) {
                    if ($mealtimes[$index]['kcal'] <= (($norms['kcal'] * $mealtime['procent']['min'] / 100) / 2)) {
                        $is_can_be_maindish = true;
                    }
                }
                $min_value_for_rand = $is_can_be_maindish ? 1 : 2;
                $randvalue = rand($min_value_for_rand, 3);
                while (true) {
                    if ($randvalue == 1) {
                        $choosed_meal_or_product = Recipe::find(self::randElem($recipes_maindishes)['id']);
                    } else if ($randvalue == 2) {
                        $choosed_meal_or_product = Recipe::find(self::randElem($recipes_other)['id']);
                    } else {
                        $choosed_meal_or_product = Recipe::find(self::randElem($products)['id']);
                    }
                    //if meal kcal in norm, the cicle can be break
                    if (($mealtimes[$index]['kcal'] + $choosed_meal_or_product['kcal']) <= ($norms['kcal'] * $mealtime['procent']['max'] / 100))
                        break;
                }
                array_push($mealtimes[$index]['meals'], $choosed_meal_or_product);
                $mealtimes[$index]['kcal'] += $choosed_meal_or_product['kcal'];
            }
            $index = $index != 4 ? $index + 1 : 0;
        }



        //save to db
        //later (after testing)

        //print result

        $text = "";
        foreach ($mealtimes as $mealtime) {
            $text .= "<b>" . $mealtime['title'] . " (" . $mealtime['kcal'] . " ккал):</b> ";
            foreach ($mealtime['meals'] as $meal) {
                if (isset($meal['product'])) {
                    $text .= $meal['product']['title'] . " - " . $meal['weigth'] . " г., ";
                } else {
                    $text .= $meal['title'] . ", ";
                }
            }
            $text = rtrim($text, ", ");
            $text .= "<br>";
        }
        $text .= "<br><b>Всього:</b> " . ($mealtimes[0]['kcal'] + $mealtimes[1]['kcal'] + $mealtimes[2]['kcal'] + $mealtimes[3]['kcal'] + $mealtimes[4]['kcal']) . " ккал.";
        return [
            "text" => $text,
            'data' => $mealtimes,
        ];
    }
}
