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

    public function __construct(array|int $data)
    {
        if(is_int($data)) $data=Workout::find($data);
        
        $this->id=$data['id'];
        $this->title=$data['title'];
        $this->description=$data['description'];
        $this->kcal=$data['kcal'];
    }
}
