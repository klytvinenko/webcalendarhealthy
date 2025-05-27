<?php

namespace App\Services;

use App\Data;
use App\DB;
use App\Models\User;
use App\Models\Workout;

class TrainingService
{
    public static function today()
    {
        $trainings = DB::selectByQuery('SELECT * FROM workouts_user WHERE date="' . Data::today() . '" AND user_id=' . User::id().';');
        $kcal = 0;
        $workouts = [];

        foreach ($trainings as $training) {
            $minutes = round(abs(strtotime($training['end_time']) - strtotime($training['start_time'])) / 60);
            $workout = new Workout($training['workout_id']);
            $kcal_by_training = round(($minutes * $workout->kcal) / 60);
            $kcal += $kcal_by_training;
            array_push($workouts, [
                'id' => $training['id'],
                'title' => $workout->title,
                'workout' => $training['workout_id'],
                'date' => $training['start_time'],
                'kcal' => $kcal_by_training,
                'times' => [
                    $training['start_time'],
                    $training['end_time'],
                ]
            ]);
        }

        return [
            "trainings" => $workouts,
            "kcal" => $kcal,
        ];
    }

    public static function bydate($date)
    {
        $trainings = DB::selectByQuery('SELECT * FROM workouts_user WHERE date="' . $date . '" AND user_id=' . User::id().';');
        $kcal = 0;
        $workouts = [];

        foreach ($trainings as $training) {
            $minutes = round(abs(strtotime($training['end_time']) - strtotime($training['start_time'])) / 60);
            $workout = new Workout($training['workout_id']);
            $kcal_by_training = round(($minutes * $workout->kcal) / 60);
            $kcal += $kcal_by_training;
            array_push($workouts, [
                'id' => $training['id'],
                'title' => $workout->title,
                'workout' => $training['workout_id'],
                'date' => $training['start_time'],
                'kcal' => $kcal_by_training,
                'times' => [
                    $training['start_time'],
                    $training['end_time'],
                ]
            ]);
        }

        return [
            "trainings" => $workouts,
            "kcal" => $kcal,
        ];
    }
}
