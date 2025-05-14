<?php

namespace App\Models;

use App\DB;
enum RecipeType: string
{
    case MAIN = 'maindish';
    case MEAT = 'meat';
    case GARNIR = 'garnir';
    case DESSERT = 'dessert';
    case BAKERY = 'bakery';
    case DRINK = 'drink';
    case SALAD = 'salad';
    case SOUP = 'soup';
    case OTHER = 'other';
}

class Recipe extends Model
{
    protected static $table = 'recipes';
    public static function fulldata()
    {
        $products = DB::select('products', '*', '', '', '10');
        foreach ($products as $product) {
            $product['diets'] = "";
            $product['allergies'] = '';
        }
        return $products;
    }
    public function allergies()
    {
        return [];
    }

    public function diets()
    {
        return [];

    }
    public function ingredients()
    {
        return [];
    }

    static function types()
    {
        return [
            [
                'id' => 'maindish',
                'title' => 'Основна страва'
            ],
            [
                'id' => "meat",
                'title' => "М'ясна страва"
            ],
            [
                'id' => "garnir",
                'title' => "Гарнір"
            ],
            [
                'id' => "dessert",
                'title' => "Десерт",
            ],
            [
                'id' => "bakery",
                'title' => "Випічка",
            ],
            [
                'id' => "drink",
                'title' => "Напій",
            ],
            [
                'id' => "salad",
                'title' => "Салат",
            ],
            [
                'id' => "soup",
                'title' => "Суп",
            ],
            [
                'id' => "other",
                'title' => "Інше",
            ]
        ];
    }

}
