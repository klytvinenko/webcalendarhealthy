<?php

namespace App\Services;

use App\Data;
use App\Models\Meal;
use App\Models\User;


class MealService
{

    public static function bydate(string $date)
    {
        $user_id = User::id();
        //find menu
        $meals = Meal::where("user_id=$user_id AND date='$date'");

        if (empty($meals)) {
            return [
                'text' => [],
                'data' => [],
            ];
        }

        $data = [
            'breakfast' => [],
            'snack1' => [],
            'lunch' => [],
            'snack2' => [],
            'dinner' => [],
        ];
        foreach ($meals as $meal) {
            array_push($data[$meal['time']], $meal);
        }

        $text = [];
        foreach ($data as $meals_by_time) {

            $meals_with_weigths = [];
            foreach ($meals_by_time as $key => $meal) {
                $meal_full = new Meal($meal['id']);
                array_push($meals_with_weigths, $meal_full->title . ' - ' . $meal_full->weight . 'г');
            }
            array_push($text, implode(', ', $meals_with_weigths));
        }

        return [
            'text' => $text,
            'data' => $data,
        ];
    }
    public static function calcProcent($time)
    {
        $norms=UserService::norms();
        $procent=$norms[$time]['avg'];
        $norm=$norms['norms']['kcal'];
        return round(($procent*$norm)/100);

    }




}