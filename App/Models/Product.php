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
    public User $user;
    public bool $is_copy;
    public bool $has_copies;
    public array $copies;
    public bool $can_be_delete;

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

        $this->approved=is_null($data['user_id']);//затверджений
        $this->user=$this->approved?new User(1):new User($data['user_id']);
        $this->is_copy=$this->isCopy();
        $this->can_be_delete=$this->canBeDelete();
        $this->copies=$this->getCopies();
        $this->has_copies=!empty($this->copies);


        $this->allergies=$this->allergies();
        $this->diets=$this->diets();
    
    
    }
    public function canBeDelete(){
        if(!empty(DB::select('meals','id',"product_id=".$this->id))) return false;
        if(!empty(DB::select('products_in_recipes','id',"product_id=".$this->id))) return false;
        if(!empty(DB::select('liked_products','id',"product_id=".$this->id))) return false;
        else return true;
    }
    public function getCopies(){
        $id=$this->id;
        $title=$this->title;
        $copies=DB::select('products','*',"id>$id AND title='$title'");
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
           $finded=DB::select('products','id',"id!=$id AND title='$title'");
           return !empty($finded);
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
