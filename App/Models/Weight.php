<?php

namespace App\Models;

use App\Data;
use App\DB;

class Weight extends Model
{
    protected static $table = "weigths";

    public int $id;
    public int $value;
    public int $user_id;
    public string $date_of_update;
    public function __construct(array|int $data)
    {

        if (is_int($data)) {
            $data = Weight::find($data);
        }
        $this->id = $data["id"];
        $this->value = $data['weigth'];
        $this->user_id = $data['user_id'];
        $this->date_of_update = $data['date_of_update'];
    }


    public static function getWeight($date = null)
    {
        if (is_null($date)) {
            $date = Data::today();
        }
        $current_weight = DB::selectOne('weigths', 'id', "date_of_update='$date' AND user_id=" . User::id() . ";");
        
        if (empty($current_weight))
            return null;
        $current_weight_id=$current_weight['id'];
        $res = new Weight($current_weight_id);
        return $res;
    }
    public static function setWeight($weight, $date_of_update = null)
    {
        $date_of_update = !is_null($date_of_update) ?$date_of_update : Data::today();
        echo $date_of_update;

        //check if exist
        $exists = Weight::where("user_id=" . User::id() . " AND date_of_update='$date_of_update'");
        if (empty($exists)) {

            $res = DB::insert('weigths', [
                'user_id' => User::id(),
                'weigth' => $weight,
                'date_of_update' => $date_of_update,
            ]);
            return $res;
        } else {
            $res = DB::update('weigths', "user_id=" . User::id() . " AND date_of_update='" . $date_of_update . "'", [
                'user_id' => User::id(),
                'weigth' => $weight,
            ]);
            return $res;
        }


    }


}
