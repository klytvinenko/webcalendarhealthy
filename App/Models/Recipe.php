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

    public bool $approved;
    public User $user;
    public bool $is_copy;
    public bool $has_copies;
    public array $copies;
    public bool $can_be_delete;

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
        $this->kcal = round($this->kcal);
        $this->fat = round($this->fat);
        $this->protein = round($this->protein);
        $this->carbonation = round($this->carbonation);
        $this->na = round($this->na);
        $this->cellulose = round($this->cellulose);
        $this->diets = $this->diets();
        $this->allergies = $this->allergies();

        $this->approved=is_null($data['user_id']);//затверджений
        $this->user=$this->approved?new User(1):new User($data['user_id']);
        $this->is_copy=$this->isCopy();
        $this->can_be_delete=$this->canBeDelete();
        $this->copies=$this->getCopies();
        $this->has_copies=!empty($this->copies);
    }
    public function canBeDelete(){
        if(!empty(DB::select('meals','id',"recipe_id=".$this->id))) return false;
        if(!empty(DB::select('products_in_recipes','id',"recipe_id=".$this->id))) return false;
        if(!empty(DB::select('liked_recipes','id',"recipe_id=".$this->id))) return false;
        else return true;
    }
    public function getCopies(){
        $id=$this->id;
        $title=$this->title;
        $copies=DB::select('recipes','*',"id>$id AND title='$title'");
        $res=[];
        foreach ($copies as $copy) {
            $user=new User($copy['user_id']);
            $copy['user_login']=$user->login;
            $res[]=$copy;
        }
        return $res;
    }
    public function isCopy(){
        if($this->approved==true) return false;
        else{
        $id=$this->id;
        $title=$this->title;
           $finded=DB::select('recipes','id',"id!=$id AND title='$title'");
           return !empty($finded);
        }
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
