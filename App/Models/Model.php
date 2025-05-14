<?php

namespace App\Models;
use App\DB;
use Exception;

abstract class Model
{
    protected static $table;
    public static function all()
    {
        if(is_null(static::$table)) echo "table is null";
        return DB::select(static::$table);
    }
    public static function where(string $conditions,$order=null,$limit=null)
    {
        return DB::select(static::$table,"*",$conditions,$order,$limit);
    }
    public static function find($id)
    {
        return DB::selectOne(static::$table, "*", "id=". $id);

    }
    public static function create(array $data)
    {
        return DB::insert(static::$table, $data);
    }
    public static function update(string $condition,array $data)
    {
        return DB::update(static::$table, $condition, $data);
    }
    public static function delete(string $condition){
        return DB::delete(static::$table, $condition);
        
    }

    

}
