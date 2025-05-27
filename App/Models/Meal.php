<?php

namespace App\Models;

use App\Data;
use App\DB;

class Meal extends Model
{

    protected static $table = "meals";

    public int $id;
    public int $user_id;
    public string $title;
    public string $time;
    public string $date;
    public int $weight;
    public Recipe $recipe;
    public Product $product;
    public string $description;
    public float $kcal;
    public float $fat;
    public float $protein;
    public float $carbonation;
    public float $na;
    public float $cellulose;
    public array $allergies;
    public array $diets;
    public array $ingredients;

    public function __construct(array|int $data)
    {
        if (is_int($data)) {
            $data = Meal::find($data);
        }
        $this->id = $data['id'];
        // $this->title = $data['title'];
        $this->time = $data['time'];
        $this->date = $data['date'];
        $this->user_id = $data['user_id'];

        if (!is_null($data['recipe_id'])) {

            $this->recipe = new Recipe($data['recipe_id']);
            $this->title = $this->recipe->title;
            $this->description = $this->recipe->description;
            $this->weight = $data['weigth'];
            $procent=($this->weight*100)/$this->recipe->weight;
            $this->ingredients = $this->recipe->ingredients;

            $this->kcal = round($this->recipe->kcal*($procent/100));
            $this->fat = round($this->recipe->fat*($procent/100));
            $this->protein = round($this->recipe->protein*($procent/100));
            $this->carbonation = round($this->recipe->carbonation*($procent/100));
            $this->na =round($this->recipe->na*($procent/100));
            $this->cellulose = round($this->recipe->cellulose*($procent/100));

            $this->diets = $this->recipe->diets;
            $this->allergies = $this->recipe->allergies;
        } else {

            $this->product = new Product($data['product_id']);
            $this->title = $this->product->title;
            $this->weight = $data['weigth'];
            $this->description = "";

            $this->kcal = round(($this->product->kcal * $this->weight) / 100);
            $this->fat = round(($this->product->fat * $this->weight) / 100);
            $this->protein = round(($this->product->protein * $this->weight) / 100);
            $this->carbonation = round(($this->product->carbonation * $this->weight) / 100);
            $this->na = round(($this->product->na * $this->weight) / 100);
            $this->cellulose = round(($this->product->cellulose * $this->weight) / 100);

            $this->diets = $this->product->diets;
            $this->allergies = $this->product->allergies;
        }
    }

    public static function today()
    {
        return self::bydate(Data::today());
    }
    public static function bydate($date)
    {
        $user_id = User::id();

        $data = DB::select('meals', '*', 'user_id=' . $user_id . ' AND date="' . $date . '"');
        $meals = [];
        foreach ($data as $item) {
            array_push($meals, new Meal($item));
        }
        return $meals;


    }

}