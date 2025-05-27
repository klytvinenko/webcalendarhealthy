<?php

namespace App\Controllers;

use App\Data;
use App\DB;
use App\Models\Workout;
use App\Models\User;
use App\Router;
use App\Services\TrainingService;

class WorkoutController extends Controller
{
    public function index()
    {
        $item_on_page = 10;
        $workouts = Workout::pagination($item_on_page);
        self::render('Тренування', 'profile/workouts', 'main', [
            'user' => new User(User::id()),
            'workouts' => $workouts,
            'item_on_page' => $item_on_page
        ]);
    }

    public function indexbyadmin()
    {

        $workouts = Workout::all();

        self::render('Тренування', 'admin/workouts', 'admin', [
            'workouts' => $workouts
        ]);
    }
    public function APItoday()
    {
        try {
            $workouts = TrainingService::today()['trainings'];
            echo json_encode([
                'data' => $workouts,
                'status' => 1,
                'message' => 'successful',
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 0,
                'message' => $e->getMessage(),
            ]);
        }


    }
    public function add()
    {
        self::render('Додати тренування', 'profile_form/workout', 'main', [
            'user' => new User(User::id())
        ]);
    }

    public function storeworkout($request)
    {
        Workout::create([
            "title" => $request['title'],
            "description" => $request['description'],
            "kcal" => $request['kcal'],
        ]);
        Router::redirect('/profile/workouts');
    }
    public function addbyadmin()
    {
        self::render('Додати тренування', 'admin_form/workout', 'admin');
    }

    public function storeworkoutbyadmin($request)
    {
        Workout::create([
            "title" => $request['title'],
            "description" => $request['description'],
            "kcal" => $request['kcal'],
        ]);
        Router::redirect('/admin/workouts');
    }
    public function APIstore($request)
    {
        try {
            $res = DB::insert('workouts_user', [
                'user_id' => User::id(),
                'workout_id' => $request['type'],
                'start_time' => $request['start_time'],
                'end_time' => $request['end_time'],
                'date' => $request['date'] ?? Data::today(),
            ]);
            echo json_encode([
                'status' => 1,
                'message' => $res,
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 0,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function edit($params)
    {
        $id = $params['id'];
        $workout = new Workout($id);
        self::render($workout->title, 'profile_form/workout_edit', 'main', ['workout' => $workout]);
    }
    public function editbyadmin($params)
    {
        $id = $params['id'];
        $workout = new Workout($id);
        self::render($workout->title, 'admin_form/workout_edit', 'admin', ['workout' => $workout]);
    }
    public function updateworkout($params, $request)
    {
        $id = $params['id'];
        Workout::update('id=' . $id, [
            "title" => $request['title'],
            "description" => $request['description'],
            "kcal" => $request['kcal'],
        ]);
        Router::redirect('/profile/workouts');
    }
    public function updateworkoutbyadmin($params, $request)
    {
        $id = $params['id'];
        Workout::update('id=' . $id, [
            "title" => $request['title'],
            "description" => $request['description'],
            "kcal" => $request['kcal'],
        ]);
        Router::redirect('/admin/workouts');
    }
    public function deleteworkoutbyadmin($id)
    {
        DB::delete('workouts_user', "workout_id=" . $id);
        Workout::delete("id=" . $id);
        // Router::redirect('/admin/workouts');
    }

    public function deleteworkout($id)
    {
        DB::delete('workouts_user', "workout_id=" . $id);
        Workout::delete("id=" . $id);
        echo 1;
        // Router::redirect('/profile/workouts');
    }
}
