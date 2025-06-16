<?php


namespace App\Services;

use App\Data;
use App\DB;
use App\Models\Meal;
use App\Models\Product;
use App\Models\Recipe;
use App\Models\RecipeType;
use App\Models\User;

class MenuGenerateService
{
    public static $times = ['breakfast', 'snack1', 'lunch', 'snack2', 'dinner'];
    public static array $static_weigth = [
        'maindish' => 150,
        'drink' => 200,
        'salad' => 70,
        'meat' => 80,
        'garnir' => 150,
        'soup' => 250,
        'dessert' => 100,
        'bakery' => 100,
        'other' => 100,
        'product' => 125,
    ];
    public User $user;
    public array $dates;
    public array $maindishes;
    public array $drinks;
    public array $salads;
    public array $meats;
    public array $garnirs;
    public array $soups;
    public array $desserts;
    public array $bakeries;
    public array $others;
    public array $products;
    public array $res_data;

    public bool $priority_by_liked;
    public bool $no_sweets;
    public bool $no_bakery;


    public string $query_for_diets_in_products;
    public string $query_for_allergies_in_products;
    public string $query_for_diets_in_recipes;
    public string $query_for_allergies_in_recipes;

    public function run($parameters, $dates = [])
    {
        foreach (['priority_by_liked', 'no_sweets', 'no_bakery'] as $param) {
            $this->{$param} = $parameters[$param] ?? false;
        }

        $this->getAllData();
        $this->dates = $dates;
        foreach ($dates as $date) {
            $this->generateForDay($date);
        }

    }
    public function getAllData()
    {
        $this->user = new User();

        $allergies_ids = implode(',', $this->user->allergiesIds());
        $diets_ids = implode(',', $this->user->dietsIds());

        $this->query_for_diets_in_products = empty($diets_ids) ? '' : 'AND id IN (SELECT pid.product_id FROM product_in_diets as pid WHERE pid.diet_id IN (' . $diets_ids . '))';//test
        $this->query_for_allergies_in_products = empty($allergies_ids) ? '' : 'AND id NOT IN (SELECT aop.product_id FROM allergies_on_products as aop where aop.allergy_id IN (' . $allergies_ids . '))';//test
        $this->query_for_diets_in_recipes = empty($diets_ids) ? '' : 'AND id IN (SELECT rid.recipe_id FROM recipe_in_diets as rid WHERE rid.diet_id IN (' . $diets_ids . '))';//test
        $this->query_for_allergies_in_recipes = empty($allergies_ids) ? '' : 'AND id NOT IN (SELECT pir.recipe_id FROM products_in_recipes as pir WHERE pir.product_id IN (SELECT aop.product_id FROM allergies_on_products as aop where aop.allergy_id IN (' . $allergies_ids . ')))';//test

        $this->maindishes = $this->selectRecipesByType('maindish');
        $this->drinks = $this->selectRecipesByType('drink');
        $this->salads = $this->selectRecipesByType('salad');
        $this->meats = $this->selectRecipesByType('meat');
        $this->garnirs = $this->selectRecipesByType('garnir');
        $this->soups = $this->selectRecipesByType('soup');
        $this->desserts = $this->selectRecipesByType('dessert');
        $this->bakeries = $this->selectRecipesByType('bakery');
        $this->others = $this->selectRecipesByType('other');
        $this->products = $this->selectProducts();
    }
    public function selectRecipesByType(string $type)
    {
        $user_id = $this->user->id;
        $query_liked = $this->priority_by_liked ? ' AND id IN (SELECT recipe_id FROM liked_recipes WHERE user_id=' . $user_id . ')' : '';
        return array_column(DB::selectByQuery("SELECT id FROM recipes WHERE type='$type' " . $this->query_for_diets_in_recipes . " " . $this->query_for_allergies_in_recipes . $query_liked), 'id');
    }
    public function selectProducts()
    {
        $user_id = $this->user->id;
        $query_liked = $this->priority_by_liked ? ' AND id IN (SELECT product_id FROM liked_products WHERE user_id=' . $user_id . ')' : '';
        return array_column(DB::selectByQuery("SELECT id FROM recipes WHERE type='product' " . $this->query_for_diets_in_products . " " . $this->query_for_allergies_in_products . $query_liked), 'id');
    }
    public function getFillNeed($date, $time)
    {
        $user_norms = $this->user->norms;
        $data = $this->res_data[$date][$time]['nutrients'];
        $norms_min = $this->res_data[$date][$time]['norms'][0];
        $norms_max = $this->res_data[$date][$time]['norms'][1];
        $need_fill = [
            'plan_min' => [
                'kcal' => $user_norms['kcal'] * ($norms_min / 100) - $data['kcal'],
                'fat' => $user_norms['fat'] * ($norms_min / 100) - $data['fat'],
                'protein' => $user_norms['protein'] * ($norms_min / 100) - $data['protein'],
                'carbonation' => $user_norms['carbonation'] * ($norms_min / 100) - $data['carbonation'],
                'na' => $user_norms['na'] * ($norms_min / 100) - $data['na'],
                'cellulose' => -$user_norms['cellulose'] * ($norms_min / 100) - $data['cellulose'],
            ],
            'plan_max' => [
                'kcal' => $user_norms['kcal'] * ($norms_max / 100) - $data['kcal'],
                'fat' => $user_norms['fat'] * ($norms_max / 100) - $data['fat'],
                'protein' => $user_norms['protein'] * ($norms_max / 100) - $data['protein'],
                'carbonation' => $user_norms['carbonation'] * ($norms_max / 100) - $data['carbonation'],
                'na' => $user_norms['na'] * ($norms_max / 100) - $data['na'],
                'cellulose' => -$user_norms['cellulose'] * ($norms_max / 100) - $data['cellulose'],
            ],
            'procent' => ($data['kcal'] * 100) / ($user_norms['kcal'] * ($norms_min / 100)),
            'types' => [array_column($this->res_data[$date][$time]['meals'], 'type')]
        ];
        return $need_fill;
    }
    public function isFilled(string $date, $time)
    {
        $this->res_data[$date][$time]['filled'] = $this->res_data[$date][$time]['nutrients']['kcal'] >= (MealService::calcProcent($time) - 50);
    }
    public function generateForDay(string $date)
    {
        $this->res_data[$date] = [
            'breakfast' => [
                'meals' => [],
                'norms' => [25, 25],
                'filled' => false,
                'nutrients' => [
                    'kcal' => 0,
                    'fat' => 0,
                    'protein' => 0,
                    'carbonation' => 0,
                    'na' => 0,
                    'cellulose' => 0,
                ]
            ],
            'snack1' => [
                'meals' => [],
                'norms' => [5, 10],
                'filled' => false,
                'nutrients' => [
                    'kcal' => 0,
                    'fat' => 0,
                    'protein' => 0,
                    'carbonation' => 0,
                    'na' => 0,
                    'cellulose' => 0,
                ]
            ],
            'lunch' => [
                'meals' => [],
                'norms' => [40, 45],
                'filled' => false,
                'nutrients' => [
                    'kcal' => 0,
                    'fat' => 0,
                    'protein' => 0,
                    'carbonation' => 0,
                    'na' => 0,
                    'cellulose' => 0,
                ]
            ],
            'snack2' => [
                'meals' => [],
                'norms' => [10, 15],
                'filled' => false,
                'nutrients' => [
                    'kcal' => 0,
                    'fat' => 0,
                    'protein' => 0,
                    'carbonation' => 0,
                    'na' => 0,
                    'cellulose' => 0,
                ]
            ],
            'dinner' => [
                'meals' => [],
                'norms' => [15, 20],
                'filled' => false,
                'nutrients' => [
                    'kcal' => 0,
                    'fat' => 0,
                    'protein' => 0,
                    'carbonation' => 0,
                    'na' => 0,
                    'cellulose' => 0,
                ]
            ],
            'nutrients' => [
                'kcal' => 0,
                'fat' => 0,
                'protein' => 0,
                'carbonation' => 0,
                'na' => 0,
                'cellulose' => 0,
            ],
            'ids' => [
                'products' => [],
                'recipes' => [],
            ],
        ];
        //fill main meal
        foreach (['breakfast', 'lunch', 'dinner'] as $time) {
            $this->createMainMeal($date, $time);
        }
        //fill snacks
        foreach (['snack1', 'snack2'] as $time) {
            $this->createSnack($date, $time);
        }
        $this->calcNutrients($date);
        foreach (self::$times as $time) {
            $this->isFilled($date, $time);
        }
        //check id enough
        $is_have_norm = false;
        if ($this->res_data[$date]['nutrients']['kcal'] > ($this->user->norms['kcal'] * 0.95))
            $is_have_norm = true;
        $counter = 0;
        foreach (self::$times as $time) {
            if ($this->res_data[$date][$time]['filled'])
                $counter++;
        }
        if ($counter == 5)
            $is_have_norm = true;
        //add if need
        if (!$is_have_norm) {
            foreach (self::$times as $time) {
                if (!$this->res_data[$date][$time]['filled']) {
                    $this->fillMealTimeToEnd($date, $time);
                    $this->calcNutrients($date);
                }
            }
        }
    }
    public function createMainMeal($date, $time)
    {
        $need_fill = $this->getFillNeed($date, $time);

        $variants = [];
        if (!empty($this->maindishes))
            array_push($variants, 0);
        if (!empty($this->soups))
            array_push($variants, 1);
        if (!empty($this->garnirs) || !empty($this->meats) || !empty($this->salads))
            array_push($variants, 2);

        $variant = $this->randItemInArray($variants);
        if ($variant == 0) {
            $this->generateMeal($need_fill, $this->maindishes, $date, $time, 'maindish');

        } else if ($variant == 1) {
            $this->generateMeal($need_fill, $this->soups, $date, $time, 'soup');

        } else if ($variant == 2) {
            $this->generateMeal($need_fill, $this->garnirs, $date, $time, 'garnir');
            $this->generateMeal($need_fill, $this->meats, $date, $time, 'meat');
            $this->generateMeal($need_fill, $this->salads, $date, $time, 'salad');
        }
    }
    public function createSnack($date, $time)
    {
        $need_fill = $this->getFillNeed($date, $time);

        $variants = [];
        if (!empty($this->products))
            array_push($variants, 0);
        if (!empty($this->bakeries) && !$this->no_bakery)
            array_push($variants, 1);
        if (!empty($this->desserts) && !$this->no_sweets)
            array_push($variants, 2);
        // if (!empty($this->others))
        //     array_push($variants, 3);

        $this->generateMeal($need_fill, $this->drinks, $date, $time, 'drink');

        $this->isFilled($date, $time);
        if (!$this->res_data[$date][$time]['filled']) {
            $variant = $this->randItemInArray($variants);
            if ($variant == 0) {
                $this->generateMeal($need_fill, $this->products, $date, $time, 'product');
            } else if ($variant == 1) {
                $this->generateMeal($need_fill, $this->bakeries, $date, $time, 'bakery');
            } else if ($variant == 2) {
                $this->generateMeal($need_fill, $this->desserts, $date, $time, 'dessert');
            } else if ($variant == 3) {
                $this->generateMeal($need_fill, $this->others, $date, $time, 'other');
            }
        }
    }
    public function findType($date, $time, $finded_type)
    {
        return in_array($finded_type, array_column($this->res_data[$date][$time]['meals'], 'type'));
    }
    public function fillMealTimeToEnd($date, $time)
    {
        $need_fill = $this->getFillNeed($date, $time);
        if (in_array($time, ['breakfast', 'lunch', 'dinner'])) {
            $this->generateMeal($need_fill, $this->drinks, $date, $time, 'drink');
        }
        $this->isFilled($date, $time);
        if (!$this->res_data[$date][$time]['filled']) {
            $need_fill = $this->getFillNeed($date, $time);

            if ($need_fill['procent'] <= 50 && in_array($time, ['breakfast', 'lunch', 'dinner'])) {
                $have_soup = $this->findType($date, $time, 'soup');
                $variants = [];
                if (!empty($this->maindishes) && $have_soup)
                    array_push($variants, 0);
                if (!empty($this->soups) && !$have_soup)
                    array_push($variants, 1);
                if ((!empty($this->garnirs) || !empty($this->meats) || !empty($this->salads)) && $have_soup)
                    array_push($variants, 2);

                $variant = $this->randItemInArray($variants);
                if ($variant == 0) {
                    $this->generateMeal($need_fill, $this->maindishes, $date, $time, 'maindish');

                } else if ($variant == 1) {
                    $this->generateMeal($need_fill, $this->soups, $date, $time, 'soup');

                } else if ($variant == 2) {
                    $this->generateMeal($need_fill, $this->garnirs, $date, $time, 'garnir');
                    $this->generateMeal($need_fill, $this->meats, $date, $time, 'meat');
                    $this->generateMeal($need_fill, $this->salads, $date, $time, 'salad');
                }
            } else {
                $variants = [];
                if (!empty($this->products))
                    array_push($variants, 0);
                if (!empty($this->bakeries) && !$this->no_bakery)
                    array_push($variants, 1);
                if (!empty($this->desserts) && !$this->no_sweets)
                    array_push($variants, 2);
                if (!empty($this->others) && in_array($time, ['breakfast', 'lunch', 'dinner']))
                    array_push($variants, 3);


                $variant = $this->randItemInArray($variants);
                if ($variant == 0) {
                    $this->generateMeal($need_fill, $this->products, $date, $time, 'product');
                } else if ($variant == 1) {
                    $this->generateMeal($need_fill, $this->bakeries, $date, $time, 'bakery');
                } else if ($variant == 2) {
                    $this->generateMeal($need_fill, $this->desserts, $date, $time, 'dessert');
                } else if ($variant == 3) {
                    $this->generateMeal($need_fill, $this->others, $date, $time, 'other');
                }
            }
        }


    }
    public function generateMeal($need_fill, array $array, $date, string $time, $type)
    {
        //find meal by id
        $meal_finded = $this->findMeal($need_fill, $array, $date, $type);
        //get meal
        $meal = $type != 'product' ? new Recipe($meal_finded['meal_id']) : new Product($meal_finded['meal_id']);
        //get weigth
        $weight = $meal_finded['weigth'];
        //add meal to data
        array_push($this->res_data[$date][$time]['meals'], [
            'type' => $type,
            'meal' => $meal,
            'weigth' => $meal_finded['weigth'],
        ]);
        //add id to data, for not repeat
        if ($type != 'product')
            array_push($this->res_data[$date]['ids']['recipes'], $meal_finded['meal_id']);
        else
            array_push($this->res_data[$date]['ids']['products'], $meal_finded['meal_id']);
        //calc nutrients
        $this->calcNutrients($date, $time, $meal, $type, $weight);

    }
    public function generateSecondMeal(array $need_fill, $date, string $time)
    {
        $meal_finded = $this->findSecondMeal($need_fill, $date, $time);

        $salad = new Recipe($meal_finded['salad_id']);
        $meat = new Recipe($meal_finded['meat_id']);
        $garnir = new Recipe($meal_finded['garnir_id']);

        array_merge($this->res_data[$date][$time]['meals'], [
            [
                'type' => 'salad',
                'meal' => $salad,
                'weigth' => $meal_finded['salad_weigth'],
            ],
            [
                'type' => 'meat',
                'meal' => $meat,
                'weigth' => $meal_finded['meat_weigth']
            ],
            [
                'type' => 'garnir',
                'meal' => $garnir,
                'weigth' => $meal_finded['garnir_weigth'],
            ]
        ]);

        array_merge($this->res_data[$date]['ids']['recipes'], [$meal_finded['salad_id'], $meal_finded['meat_id'], $meal_finded['garnir_id']]);

        $this->calcNutrients($date, $time, $salad, 'salad', $meal_finded['salad_weigth']);
        $this->calcNutrients($date, $time, $meat, 'meat', $meal_finded['meat_weigth']);
        $this->calcNutrients($date, $time, $garnir, 'garnir', $meal_finded['garnir_weigth']);
    }
    public function findMeal(array $need_fill, array $array, $date, $type)
    {
        $meals = [];
        foreach ($array as $id) {
            $weigth = $type != 'product' ? self::$static_weigth[$type] : $this->randWeight();

            $recipe_or_product = $type != 'product' ? new Recipe($id) : new Product($id);
            if ($recipe_or_product->weight == 0)
                continue;
            $weigth_full = $type != 'product' ? $recipe_or_product->weight : 100;
            $meal = [
                'kcal' => ($weigth * $recipe_or_product->kcal) / $weigth_full,
                'fat' => ($weigth * $recipe_or_product->fat) / $weigth_full,
                'protein' => ($weigth * $recipe_or_product->protein) / $weigth_full,
                'carbonation' => ($weigth * $recipe_or_product->carbonation) / $weigth_full,
                'na' => ($weigth * $recipe_or_product->na) / $weigth_full,
                'cellulose' => ($weigth * $recipe_or_product->cellulose) / $weigth_full,
            ];

            $points = 0;

            if ($meal['kcal'] <= $need_fill['plan_min']['kcal'])
                $points += 2;
            else if ($meal['kcal'] >= $need_fill['plan_min']['kcal'] && $meal['kcal'] <= $need_fill['plan_max']['kcal'])
                $points++;
            if ($meal['fat'] <= $need_fill['plan_min']['fat'])
                $points += 2;
            else if ($meal['fat'] >= $need_fill['plan_min']['fat'] && $meal['fat'] <= $need_fill['plan_max']['fat'])
                $points++;
            if ($meal['protein'] <= $need_fill['plan_min']['protein'])
                $points += 2;
            else if ($meal['protein'] >= $need_fill['plan_min']['protein'] && $meal['protein'] <= $need_fill['plan_max']['protein'])
                $points++;
            if ($meal['carbonation'] <= $need_fill['plan_min']['carbonation'])
                $points += 2;
            else if ($meal['carbonation'] >= $need_fill['plan_min']['carbonation'] && $meal['carbonation'] <= $need_fill['plan_max']['carbonation'])
                $points++;
            if ($meal['na'] <= $need_fill['plan_min']['na'])
                $points += 2;
            else if ($meal['na'] >= $need_fill['plan_min']['na'] && $meal['na'] <= $need_fill['plan_max']['na'])
                $points++;
            if ($meal['cellulose'] <= $need_fill['plan_min']['cellulose'])
                $points += 2;
            else if ($meal['cellulose'] >= $need_fill['plan_min']['cellulose'] && $meal['cellulose'] <= $need_fill['plan_max']['cellulose'])
                $points++;

            array_push($meals, [
                'points' => $points,
                'meal_id' => $id,
                'now_use' => $type != 'product' ? in_array($id, $this->res_data[$date]['ids']['recipes']) : in_array($id, $this->res_data[$date]['ids']['products']),
                'weigth' => $weigth
            ]);
        }
        $max_points = 0;
        foreach ($meals as $meal) {
            if ($meal['points'] >= $max_points && $meal['now_use'] == false)
                $max_points = $meal['points'];
        }
        $filtered_meals = [];
        foreach ($meals as $meal) {
            if ($meal['points'] == $max_points)
                array_push($filtered_meals, $meal);
        }

        return $this->randItemInArray($filtered_meals);
    }
    public function findSecondMeal(array $need_fill, $date)
    {
        $salad_weigth = self::$static_weigth['salad'];
        $meat_weigth = self::$static_weigth['meat'];
        $garnir_weigth = self::$static_weigth['garnir'];

        $meals = [];
        foreach ($this->salads as $salad_id) {
            $salad = new Recipe($salad_id);

            $salad_nutrients = [
                'kcal' => ($salad_weigth * $salad->kcal) / $salad->weight,
                'fat' => ($salad_weigth * $salad->fat) / $salad->weight,
                'protein' => ($salad_weigth * $salad->protein) / $salad->weight,
                'carbonation' => ($salad_weigth * $salad->carbonation) / $salad->weight,
                'na' => ($salad_weigth * $salad->na) / $salad->weight,
                'cellulose' => ($salad_weigth * $salad->cellulose) / $salad->weight,
            ];
            foreach ($this->meats as $meat_id) {
                $meat = new Recipe($meat_id);
                $meat_nutrients = [
                    'kcal' => ($meat_weigth * $meat->kcal) / $meat->weight,
                    'fat' => ($meat_weigth * $meat->fat) / $meat->weight,
                    'protein' => ($meat_weigth * $meat->protein) / $meat->weight,
                    'carbonation' => ($meat_weigth * $meat->carbonation) / $meat->weight,
                    'na' => ($meat_weigth * $meat->na) / $meat->weight,
                    'cellulose' => ($meat_weigth * $meat->cellulose) / $meat->weight,
                ];
                foreach ($this->garnirs as $garnir_id) {
                    $garnir = new Recipe($garnir_id);

                    $garnir_nutrients = [
                        'kcal' => ($garnir_weigth * $garnir->kcal) / $garnir->weight,
                        'fat' => ($garnir_weigth * $garnir->fat) / $garnir->weight,
                        'protein' => ($garnir_weigth * $garnir->protein) / $garnir->weight,
                        'carbonation' => ($garnir_weigth * $garnir->carbonation) / $garnir->weight,
                        'na' => ($garnir_weigth * $garnir->na) / $garnir->weight,
                        'cellulose' => ($garnir_weigth * $garnir->cellulose) / $garnir->weight,
                    ];
                    $meal = [
                        'kcal' => $salad_nutrients['kcal'] + $meat_nutrients['kcal'] + $garnir_nutrients['kcal'],
                        'fat' => $salad_nutrients['kcal'] + $meat_nutrients['fat'] + $garnir_nutrients['fat'],
                        'protein' => $salad_nutrients['kcal'] + $meat_nutrients['protein'] + $garnir_nutrients['protein'],
                        'carbonation' => $salad_nutrients['kcal'] + $meat_nutrients['carbonation'] + $garnir_nutrients['carbonation'],
                        'na' => $salad_nutrients['kcal'] + $meat_nutrients['na'] + $garnir_nutrients['na'],
                        'cellulose' => $salad_nutrients['kcal'] + $meat_nutrients['cellulose'] + $garnir_nutrients['cellulose'],
                    ];

                    $points = 0;

                    if ($meal['kcal'] <= $need_fill['plan_min']['kcal'])
                        $points += 2;
                    else if ($meal['kca'] >= $need_fill['plan_min']['kcal'] && $meal['kcal'] <= $need_fill['plan_max']['kcal'])
                        $points++;
                    if ($meal['fat'] <= $need_fill['plan_min']['fat'])
                        $points += 2;
                    else if ($meal['fat'] >= $need_fill['plan_min']['fat'] && $meal['fat'] <= $need_fill['plan_max']['fat'])
                        $points++;
                    if ($meal['protein'] <= $need_fill['plan_min']['protein'])
                        $points += 2;
                    else if ($meal['protein'] >= $need_fill['plan_min']['protein'] && $meal['protein'] <= $need_fill['plan_max']['protein'])
                        $points++;
                    if ($meal['carbonation'] <= $need_fill['plan_min']['carbonation'])
                        $points += 2;
                    else if ($meal['carbonation'] >= $need_fill['plan_min']['carbonation'] && $meal['carbonation'] <= $need_fill['plan_max']['carbonation'])
                        $points++;
                    if ($meal['na'] <= $need_fill['plan_min']['na'])
                        $points += 2;
                    else if ($meal['na'] >= $need_fill['plan_min']['na'] && $meal['na'] <= $need_fill['plan_max']['na'])
                        $points++;
                    if ($meal['cellulose'] <= $need_fill['plan_min']['cellulose'])
                        $points += 2;
                    else if ($meal['cellulose'] >= $need_fill['plan_min']['cellulose'] && $meal['cellulose'] <= $need_fill['plan_max']['cellulose'])
                        $points++;

                    $now_use = false;
                    if (in_array($salad_id, $this->res_data[$date]['ids']))
                        $now_use = true;
                    if (in_array($meat_id, $this->res_data[$date]['ids']))
                        $now_use = true;
                    if (in_array($garnir_id, $this->res_data[$date]['ids']))
                        $now_use = true;
                    array_push($meals, [
                        'points' => $points,
                        'salad_id' => $salad_id,
                        'now_use' => $now_use,
                        'meat_id' => $meat_id,
                        'garnir_id' => $garnir_id,
                        'salad_weigth' => $salad_weigth,
                        'meat_weigth' => $meat_weigth,
                        'garnir_weigth' => $garnir_weigth,
                    ]);
                }
            }
        }
        $max_points = 0;
        foreach ($meals as $meal) {
            if ($meal['points'] >= $max_points && $meal['now_use'] == false)
                $max_points = $meal['points'];
        }
        $filtered_meals = [];
        foreach ($meals as $meal) {
            if ($meal['points'] >= $max_points - 2)
                array_push($filtered_meals, $meal);
        }

        return $this->randItemInArray($filtered_meals);
    }
    public function randWeight()
    {
        return random_int(2, 8) * 25;
    }
    public function randItemInArray(array $array)
    {
        if (!empty($array)) {
            $count = count($array);
            $index = rand(0, $count - 1);
            return $array[$index];
        } else
            return null;

    }
    public function calcNutrients($date, string $time = 'all', $new_meal = null, $type = null, int $weight = null)
    {
        if ($time == "all" && is_null($new_meal)) {
            $this->res_data[$date]['nutrients']['kcal'] = 0;
            $this->res_data[$date]['nutrients']['fat'] = 0;
            $this->res_data[$date]['nutrients']['protein'] = 0;
            $this->res_data[$date]['nutrients']['carbonation'] = 0;
            $this->res_data[$date]['nutrients']['na'] = 0;
            $this->res_data[$date]['nutrients']['cellulose'] = 0;
            foreach (self::$times as $time) {
                $this->res_data[$date]['nutrients']['kcal'] += $this->res_data[$date][$time]['nutrients']['kcal'];
                $this->res_data[$date]['nutrients']['fat'] += $this->res_data[$date][$time]['nutrients']['fat'];
                $this->res_data[$date]['nutrients']['protein'] += $this->res_data[$date][$time]['nutrients']['protein'];
                $this->res_data[$date]['nutrients']['carbonation'] += $this->res_data[$date][$time]['nutrients']['carbonation'];
                $this->res_data[$date]['nutrients']['na'] += $this->res_data[$date][$time]['nutrients']['na'];
                $this->res_data[$date]['nutrients']['cellulose'] += $this->res_data[$date][$time]['nutrients']['cellulose'];
            }
        } else {
            if ($type != 'product') {
                $recipe_weigth = (new Recipe($new_meal->id))->weight;
                $this->res_data[$date][$time]['nutrients']['kcal'] += ($weight * $new_meal->kcal) / $recipe_weigth;
                $this->res_data[$date][$time]['nutrients']['fat'] += ($weight * $new_meal->fat) / $recipe_weigth;
                $this->res_data[$date][$time]['nutrients']['protein'] += ($weight * $new_meal->protein) / $recipe_weigth;
                $this->res_data[$date][$time]['nutrients']['carbonation'] += ($weight * $new_meal->carbonation) / $recipe_weigth;
                $this->res_data[$date][$time]['nutrients']['na'] += ($weight * $new_meal->na) / $recipe_weigth;
                $this->res_data[$date][$time]['nutrients']['cellulose'] += ($weight * $new_meal->cellulose) / $recipe_weigth;
            } else {
                $this->res_data[$date][$time]['nutrients']['kcal'] += ($weight * $new_meal->kcal) / 100;
                $this->res_data[$date][$time]['nutrients']['fat'] += ($weight * $new_meal->fat) / 100;
                $this->res_data[$date][$time]['nutrients']['protein'] += ($weight * $new_meal->protein) / 100;
                $this->res_data[$date][$time]['nutrients']['carbonation'] += ($weight * $new_meal->carbonation) / 100;
                $this->res_data[$date][$time]['nutrients']['na'] += ($weight * $new_meal->na) / 100;
                $this->res_data[$date][$time]['nutrients']['cellulose'] += ($weight * $new_meal->cellulose) / 100;
            }
        }
    }
    public function saveToDB()
    {
        $res = [];
        foreach ($this->dates as $date) {
            foreach (self::$times as $time) {
                foreach ($this->res_data[$date][$time]['meals'] as $meal) {
                    $res_of_query = Meal::create([
                        'recipe_id' => $meal['type'] != 'product' ? $meal['meal']->id : null,
                        'product_id' => $meal['type'] == 'product' ? $meal['meal']->id : null,
                        'weigth' => $meal['weigth'],
                        'user_id' => $this->user->id,
                        'date' => $date,
                        'time' => $time,
                    ]);
                    array_push($res, $res_of_query);
                }
            }
        }
        return $res;
    }
}