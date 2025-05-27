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
    public string $time;
    public function __construct(array|int $data)
    {
        if (is_int($data)) {
            $data = Weight::find($data);
        }
        if (isset($data['id'])) {
            $this->id = $data["id"];
            $this->value = $data['weigth'];
            $this->user_id = $data['user_id'];
            $this->date_of_update = date('Y-m-d', strtotime($data['date_of_update']));
            $this->time = date('H:m', strtotime($data['date_of_update']));
        }

    }
    public static function getWeight($date = null)
    {
        if (is_null($date))
            $date = Data::today();
        $current_weight = DB::selectByQuery('SELECT * FROM weigths WHERE date_of_update="' . $date . '" AND user_id=' . User::id() . ';');
        if (!empty($current_weight)||count($current_weight)==0)
            return null;
        return new Weight($current_weight[0]);
    }
    public static function setWeight($weight, $date_of_update = null)
    {
        $date_of_update = $date_of_update ?? Data::today();
        //check if exist
        $exists = Weight::where("user_id=" . User::id() . " AND date_of_update='" . $date_of_update . '"');
        if (empty($exists)) {

            $res = DB::insert('weigths', [
                'user_id' => User::id(),
                'weigth' => $weight,
                'date_of_update' => Data::today(),
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
    public static function getWeightProgress()
    {
        $res = DB::selectByQuery('SELECT w.weigth as weigth, max(w.date_of_update) as date_of_update FROM weigths as w WHERE w.user_id=' . User::id() . ' GROUP BY w.date_of_update ORDER BY w.date_of_update;');
        return $res;
    }

}
