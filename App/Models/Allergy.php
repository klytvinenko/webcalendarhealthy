<?php

namespace App\Models;

use App\DB;
class Allergy extends Model
{
    public int $id;
    public string $name;
    protected static $table = "allergies";
    public function __construct(array|int $data)
    {
        if (is_int($data))
            $data = Allergy::find($data);

        $this->id = $data['id'];
        $this->name = $data['name'];
    }
    public function recipes()
    {

        return [];//todo
    }
    public function products()
    {

        return [];//todo
    }
}
