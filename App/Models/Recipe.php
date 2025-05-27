<?php

namespace App\Models;

use App\DB;
use App\Data;
use App\Services\RecipeService;
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
    public function getName(): string
    {
        return match ($this) {
            RecipeType::MAIN => 'основна страва',
            RecipeType::MEAT => "м'ясна страва",
            RecipeType::GARNIR => 'гарнір',
            RecipeType::DESSERT => 'десерт',
            RecipeType::BAKERY => 'випічка',
            RecipeType::DRINK => 'напій',
            RecipeType::SALAD => 'салат',
            RecipeType::SOUP => 'суп',
            RecipeType::OTHER => 'інше',
        };
    }
}

class Recipe extends Model
{
    protected static $table = 'recipes';

    public int $id;
    public string $title;
    public RecipeType $type;
    public string $description;
    public bool $is_liked;
    public int $weight;
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
            $data = Recipe::find($data);
        }
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->type = RecipeType::from($data['type']);
        $this->description = $data['description'];
        $this->is_liked=RecipeService::isLiked($this->id);
        
        $this->weight = 0;

        $this->kcal = 0;
        $this->fat = 0;
        $this->protein = 0;
        $this->carbonation = 0;
        $this->na = 0;
        $this->cellulose = 0;
        $this->ingredients = $this->ingredients();
        foreach ($this->ingredients as $ingredient) {
            $this->weight += $ingredient['weight'];
            $this->kcal += Data::calcProcent($ingredient['weight'], $ingredient['kcal']);
            $this->fat += Data::calcProcent($ingredient['weight'], $ingredient['fat']);
            $this->protein += Data::calcProcent($ingredient['weight'], $ingredient['protein']);
            $this->carbonation += Data::calcProcent($ingredient['weight'], $ingredient['carbonation']);
            $this->na += Data::calcProcent($ingredient['weight'], $ingredient['na']);
            $this->cellulose += Data::calcProcent($ingredient['weight'], $ingredient['cellulose']);
        }
        $this->diets = $this->diets();
        $this->allergies = $this->allergies();

    }
    public function allergies()
    {
        return array_column(DB::selectByQuery('SELECT a.* FROM products_in_recipes as pir JOIN products AS p ON p.id=pir.product_id JOIN allergies_on_products AS aop ON p.id=aop.product_id JOIN allergies AS a ON a.id=aop.allergy_id GROUP BY a.id;'), 'name');
    }

    public function diets()
    {
        return array_column(DB::selectByQuery('SELECT d.* FROM recipe_in_diets as rid JOIN diets AS d ON d.id=rid.diet_id WHERE rid.recipe_id=' . $this->id . ';'), 'name');

    }
    
    public function dietsFull(){
        $res=DB::selectByQuery('SELECT d.* FROM recipe_in_diets as rid JOIN diets AS d ON d.id=rid.diet_id WHERE rid.recipe_id=' . $this->id . ';');
        return $res;
    }
    public function ingredients()
    {
        return DB::selectByQuery('SELECT pir.id,p.id as product_id,p.title,pir.weight as weight,p.kcal,p.na,p.carbonation,p.fat,p.protein,p.cellulose FROM products_in_recipes as pir JOIN products AS p ON p.id=pir.product_id WHERE pir.recipe_id=' . $this->id . ';');
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
