<?php

namespace App\Models;

use App\DB;
class Product extends Model
{

    protected static $table = "products";
    
    public int $id;
    public string $title;
    public string $type;
    public float $kcal;
    public float $fat;
    public float $protein;
    public float $carbonation;
    public float $na;
    public float $cellulose;
    public array $allergies;
    public array $diets;
    public bool $approved;
    public bool $is_copy;
    
    public User $user;
    public function __construct(array|int $data)
    {
        if(is_int($data)){
            $data=Product::find($data);
        }

        $this->id=$data['id'];
        $this->title=$data['title'];
        $this->type=$data['type']??'ingredient';
        $this->kcal=$data['kcal']??0;
        $this->fat=$data['fat']??0;
        $this->protein=$data['protein']??0;
        $this->carbonation=$data['carbonation']??0;
        $this->na=$data['na']??0;
        $this->cellulose=$data['cellulose']??0;
        $this->approved=is_null($data['user_id']);
        $this->user=$this->approved?new User(1):new User($data['user_id']);
        $this->is_copy=$this->isCopy();


        $this->allergies=$this->allergies();
        $this->diets=$this->diets();
    
    
    }
    public function isCopy(){
        if($this->approved==false) return false;
        else{
            
        }
    }
    public function diets(){
        $res=array_column(DB::selectByQuery('SELECT d.* FROM product_in_diets as pid JOIN diets AS d ON d.id=pid.diet_id WHERE pid.product_id=' . $this->id . ';'),'name');
        return $res;
    }
    public function allergies(){
        $res=array_column(DB::selectByQuery('SELECT a.* FROM allergies_on_products as aop JOIN allergies AS a ON a.id=aop.allergy_id WHERE aop.product_id=' . $this->id . ';'),'name');
        return $res;

    }
    public function dietsFull(){
        $res=DB::selectByQuery('SELECT d.* FROM product_in_diets as pid JOIN diets AS d ON d.id=pid.diet_id WHERE pid.product_id=' . $this->id . ';');
        return $res;
    }
    public function allergiesFull(){
        $res=DB::selectByQuery('SELECT a.* FROM allergies_on_products as aop JOIN allergies AS a ON a.id=aop.allergy_id WHERE aop.product_id=' . $this->id . ';');
        return $res;

    }
}
