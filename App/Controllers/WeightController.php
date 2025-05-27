<?php

namespace App\Controllers;

use App\Models\Weight;
use App\Router;
use App\Data;

class WeightController extends Controller
{
    public function APIstore($request)
    {
        try {
            $weight = $request['weigth'];
            $res = Weight::setWeight($weight);
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

    public function APIget()
    {
        try {
            $res = Weight::getWeight();
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
    public function APIprogress()
    {
        try {
            $res = Weight::getWeightProgress();
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
