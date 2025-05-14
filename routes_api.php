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

$router->get('/api', [UserController::class, "login"], UserType::NOTLOGINED);//example

$router->post('/api/weights/store', [WeightController::class, "APIstore"], UserType::LOGINED);
$router->post('/api/workouts/store', [WorkoutController::class, "APIstore"], UserType::LOGINED);



$router->get('/api/products/search', [ProductController::class, "search"]);//example
