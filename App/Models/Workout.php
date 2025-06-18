<?php

namespace App\Models;

use App\DB;
class Workout extends Model
{    
    public int $id;
    public string $title;
    public string $description;
    public float $kcal;
    protected static $table = "workouts";

    public bool $approved;
    public User $user;
    public bool $is_copy;
    public bool $has_copies;
    public array $copies;
    public bool $can_be_delete;

    public function __construct(array|int $data)
    {
        if(is_int($data)) $data=Workout::find($data);
        
        $this->id=$data['id'];
        $this->title=$data['title'];
        $this->description=$data['description'];
        $this->kcal=$data['kcal'];

        $this->approved=is_null($data['user_id']);//затверджений
        $this->user=$this->approved?new User(1):new User($data['user_id']);
        $this->is_copy=$this->isCopy();
        $this->can_be_delete=$this->canBeDelete();
        $this->copies=$this->getCopies();
        $this->has_copies=!empty($this->copies);
    }
    public function canBeDelete(){
        if(!empty(DB::select('workouts_user','id',"workout_id=".$this->id))) return false;
        else return true;
    }
    public function getCopies(){
        $id=$this->id;
        $title=$this->title;
        $copies=DB::select('workouts','*',"id>$id AND title='$title'");
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
           $finded=DB::select('workouts','id',"id!=$id AND title='$title'");
           return !empty($finded);
        }
    }
}
