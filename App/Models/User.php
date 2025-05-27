<?php

namespace App\Models;

use App\DB;
use App\Data;

class User extends Model
{

    protected static $table = "users";
    public int $id;
    public string $login;
    public string $email;
    public string $sex;
    public Weight $weight;
    public int $height;
    public int $age;
    public string $date_of_birth;
    public string $activity_level;
    public array $norms;
    public array $allergies;
    public $diets;
    public function __construct(array|int $data=null)
    {
        if(is_null($data)) $data=User::id();
        if (is_int($data)) {
            $data = User::find($data);
        }

        $this->id = $data['id'];
        $this->login = $data['login'];
        $this->email = $data['email'];
        $this->sex = $data['sex'] ?? "";
        $weight = Weight::getWeight();
        if(!is_null($weight)) $this->weight = $weight;
        $this->height = $data['height'] ?? 0;
        $this->date_of_birth = $data['date_of_birth'] ?? '';
        $this->update_age();
        $this->activity_level = $data['activity_level'] ?? 0;
        $this->norms = !is_null($data['norms']) ? (array) json_decode($data['norms']) : [];


        $this->allergies = $this->allergies();
        $this->diets = $this->diets();


    }

    public function update_age()
    {
        if (!empty($this->date_of_birth)) {
            $birthDate = explode("-", $this->date_of_birth);
            $this->age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1) : (date("Y") - $birthDate[0]));
        }
    }
    public function diets()
    {
        $res = array_column(DB::selectByQuery('SELECT d.* FROM users_diets as ud JOIN diets AS d ON d.id=ud.diet_id WHERE ud.user_id=' . $this->id . ';'), 'name');
        return $res;
    }
    public function allergies()
    {
        $res = array_column(DB::selectByQuery('SELECT a.* FROM users_allergies as ua JOIN allergies AS a ON a.id=ua.allergy_id WHERE ua.user_id=' . $this->id . ';'), 'name');
        return $res;

    }
    public function dietsIds()
    {
        $res = array_column(DB::selectByQuery('SELECT d.* FROM users_diets as ud JOIN diets AS d ON d.id=ud.diet_id WHERE ud.user_id=' . $this->id . ';'), 'id');
        return $res;
    }
    public function allergiesIds()
    {
        $res = array_column(DB::selectByQuery('SELECT a.* FROM users_allergies as ua JOIN allergies AS a ON a.id=ua.allergy_id WHERE ua.user_id=' . $this->id . ';'), 'id');
        return $res;

    }
    public static function id()
    {
        return $_SESSION['user']['id'];
    }

    public function calcNorms($weight)
    {
        $kcal = 0;
        if ($this->sex == 'woman') {
            $kcal = $weight * 10 + $this->height * 6.25 - $this->age * 5 - 161;
        } else {
            $kcal = $weight * 10 + $this->height * 6.25 - $this->age * 5 + 5;
        }
        $kcal = round($kcal * (float) $this->activity_level);
        //kcal other
        $this->norms['kcal'] = $kcal;
        $this->norms['fat'] = round(((3 * $kcal) / 10) / 4);
        $this->norms['protein'] = round(((2 * $kcal) / 10) / 9);
        $this->norms['carbonation'] = round(((5 * $kcal) / 10) / 4);
        $this->norms['na'] = 2000;
        $this->norms['cellulose'] = 20;
        //update data
        User::update('id=' . $this->id, [
            'norms' => json_encode($this->norms),
            'height' => $this->height,
            'age' => $this->age,
            'sex' => $this->sex,
            'date_of_birth' => $this->date_of_birth,
            'activity_level' => $this->activity_level,
        ]);
        Weight::setWeight($weight);
    }

}
