<?php

namespace App\Models;

use App\DB;
class Diet extends Model
{    public int $id;
    public string $name;
    public string $description;

    protected static $table = "diets"; 
    
    public function __construct(array|int $data)
    {
        if(is_int($data)) $data=Diet::find($data);
        
        $this->id=$data['id'];
        $this->name=$data['name'];
        $this->description=$data['description'];
    }
    public  function recipes(){

        return [];//todo
    }
    public  function products(){

    return [];//todo
}
}
