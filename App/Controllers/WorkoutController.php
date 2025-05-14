<?php

namespace App\Controllers;

use App\Data;
use App\DB;
use App\Models\Workout;
use App\Models\User;
use App\Router;

class WorkoutController extends Controller
{

    public function indexbyadmin()
    {
        $workouts = [
            [
                'title' => 'Біг підтюпцем',
                'description' => 'Легка пробіжка на відкритому повітрі або біговій доріжці зі швидкістю 8-9 км/год.',
                'kcal' => 500
            ],
            [
                'title' => 'Силове тренування',
                'description' => 'Заняття з гантелями, штангою або на тренажерах для розвитку сили та м’язів.',
                'kcal' => 450
            ],
            [
                'title' => 'Йога',
                'description' => 'Спокійна практика розтяжки, дихальних вправ і асан для гнучкості та зняття стресу.',
                'kcal' => 200
            ],
            [
                'title' => 'Плавання',
                'description' => 'Інтенсивне або середнє плавання у басейні (кроль, брас, на спині).',
                'kcal' => 600
            ],
            [
                'title' => 'Велосипед',
                'description' => 'Прогулянка або інтенсивне катання на велосипеді по місту або лісу.',
                'kcal' => 550
            ],
            [
                'title' => 'Пілатес',
                'description' => 'Комплекс вправ для розвитку м’язів-стабілізаторів, покращення постави та тонусу тіла.',
                'kcal' => 250
            ],
            [
                'title' => 'Степ-аеробіка',
                'description' => 'Групове заняття з підйомами на степ-платформу під ритмічну музику.',
                'kcal' => 500
            ],
            [
                'title' => 'Танцювальний фітнес (Zumba)',
                'description' => 'Рухливі заняття під латиноамериканську та сучасну музику.',
                'kcal' => 550
            ],
            [
                'title' => 'Ходьба швидким темпом',
                'description' => 'Прогулянка пішки зі швидкістю 6-7 км/год по парку чи місту.',
                'kcal' => 300
            ],
            [
                'title' => 'HIIT (інтервальні тренування)',
                'description' => 'Короткі інтенсивні цикли вправ із мінімальним відпочинком.',
                'kcal' => 700
            ]
        ];

        $workouts=Workout::all();
        
        self::render('Тренування', 'admin/workouts','admin',[
            'workouts'=>$workouts
        ]);
    }
    public function addbyadmin()
    {
        self::render('Додати тренування', 'admin_form/workout','admin');
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
    public function deleteworkoutbyadmin($id)
    {
        DB::delete('workouts_user', "workout_id=" . $id);
        Workout::delete("id=".$id);
        // Router::redirect('/admin/workouts');
    }
    
    public function deleteworkout($id)
    {
        DB::delete('workouts_user', "workout_id=" . $id);
        Workout::delete("id=".$id);
        // Router::redirect('/profile/workouts');
    }
}
