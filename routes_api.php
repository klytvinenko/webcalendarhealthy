<?php

use App\Controllers\RecipeController;
use App\Controllers\UserController;
use App\Controllers\ProductController;
use App\Controllers\DietController;
use App\Controllers\AllergyController;
use App\Controllers\MealController;
use App\Controllers\WeightController;
use App\Controllers\WorkoutController;
use App\UserType;

$router->get('/api', [UserController::class, "login"], UserType::NOTLOGINED); //example

$router->post('/api/weights/store', [WeightController::class, "APIstore"], UserType::LOGINED);
$router->post('/api/workouts/store', [WorkoutController::class, "APIstore"], UserType::LOGINED);
$router->post('/api/meals/store/today', [MealController::class, "APIstoremealtoday"], UserType::LOGINED);
$router->post('/api/meals/calendar/store', [MealController::class, "APIstoremealfromcalendar"], UserType::LOGINED);
$router->post('/api/weights/calendar/store', [WeightController::class, "APIstoreweightfromcalendar"], UserType::LOGINED);

$router->get('/api/weight/progress', [WeightController::class, "APIprogress"], UserType::LOGINED);
$router->get('/api/weight/get', [WeightController::class, "APIget"], UserType::LOGINED);
$router->get('/api/workouts/today', [WorkoutController::class, "APItoday"], UserType::LOGINED);//not started

$router->delete('/api/workouts/delete', [WorkoutController::class, "APIdeleteworkoutuser"], UserType::LOGINED);//not started

$router->get('/api/products/search', [ProductController::class, "search"]);
$router->get('/api/meal/search', [MealController::class, "APIsearch"]); 
$router->get('/api/users/norms', [UserController::class, "APInorms"]); 

