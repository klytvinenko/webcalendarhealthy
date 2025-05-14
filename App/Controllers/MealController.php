<?php

namespace App\Controllers;

use App\Router;
use App\Data;
class MealController extends Controller
{

    public function calendar($params)
    {
        
        $month = $params['m'] ?? date('m');
        $year = $params['y'] ?? date('Y');
        $days_in_month = date("t", mktime(0, 0, 0, $month, 1, $year));
        
        $day_of_week=date('w', timestamp: strtotime($year.'-'.$month.'-01'));
        

        $next_year = $month == '12' ? $year - 1 : $year;
        $next_month = $month == '12' ? '01' : $month + 1;
        $prev_year = $month == '01' ? $year + 1 : $year;
        $prev_month = $month == '01' ? '12' : $month - 1;

        $next_month = $next_month < 10 ? '0' . $next_month : $next_month;
        $prev_month = $prev_month < 10 ? '0' . $prev_month : $prev_month;

        $dates=[];
        $add_empty_days=null;
        if($day_of_week==0) $add_empty_days=6;
        else if($day_of_week==1) $add_empty_days=0;
        else $add_empty_days=$day_of_week-1;
        for ($i=0; $i < $add_empty_days; $i++) { 
            array_push($dates,[
                'date'=>0,
            ]);
        }
        $today=Data::today();
        for ($i=1; $i <= $days_in_month; $i++) { 
            array_push($dates,[
                'date'=>$i,
                'current_day'=>false,
                'menu'=>'',
                'trainings'=>'',
            ]);
        }
        for ($i=0; $i < (7-(($add_empty_days+$days_in_month)/7)); $i++) { 
            array_push($dates,[
                'date'=>0,
            ]);
        }

        self::render('Календар', 'profile/calendar', 'calendar', [
            'month' => $month,
            'year' => $year,
            'next_year' => $next_year,
            'next_month' => $next_month,
            'prev_year' => $prev_year,
            'prev_month' => $prev_month,
            'days_in_month' => $days_in_month,
            'dates' => $dates,
        ]);
    }
    public function generatemenuonday($request)
    {

        Router::redirect('/profile');
    }
    public function generatemenu($request)
    {

        Router::redirect('/profile/calendar');
    }
}
