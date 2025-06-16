<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Weight;
use App\Router;
use App\Data;
use App\Services\WeightService;

class WeightController extends Controller
{
    public function APIstore($request)
    {
        try {
            $weight = $request['weigth'];
            $res = Weight::setWeight($weight);

            $user = new User();
            $user->update_age();
            $user->calcNorms($weight);
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

    public function APIget($params)
    {
        try {
            $date=$params['date']??Data::today();
            $res = Weight::getWeight($date);
            echo json_encode([
                'data' => $res,
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
    public function APIstoreweightfromcalendar($request)
    {
        try {
            $date = $request['date'];
            $weight = $request['weigth'];
            $res = Weight::setWeight($weight,$date);
            $user = new User();
            $user->calcNorms($weight,$date);
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
    public function APIprogress()
    {
        try {
            $res = WeightService::weightProgress();
            echo json_encode([
                'data' => $res,
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
}
