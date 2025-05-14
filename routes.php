<?php

use App\Controllers\RecipeController;
use App\Controllers\TestController;
use App\Controllers\UserController;
use App\Controllers\ProductController;
use App\Controllers\DietController;
use App\Controllers\AllergyController;
use App\Controllers\WorkoutController;
use App\Controllers\MealController;
use App\UserType;

$router->get('/', [UserController::class, "login"], UserType::NOTLOGINED);
$router->get('/register', [UserController::class, "register"], UserType::NOTLOGINED);
$router->post('/signin', [UserController::class, "signin"], UserType::NOTLOGINED);
$router->post('/signup', [UserController::class, "signup"], UserType::NOTLOGINED);
$router->get('/logout', [UserController::class, "logout"]);

$router->get('/admin', [UserController::class, "indexbyadmin"], UserType::ADMIN);
$router->get('/admin/recipes', [RecipeController::class, "indexbyadmin"], UserType::ADMIN);
$router->get('/admin/products', [ProductController::class, "indexbyadmin"], UserType::ADMIN);
$router->get('/admin/diet', [DietController::class, "indexbyadmin"], UserType::ADMIN);
$router->get('/admin/workouts', [WorkoutController::class, "indexbyadmin"], UserType::ADMIN);

$router->get('/admin/recipes/add', [RecipeController::class, "addbyadmin"], UserType::ADMIN);
$router->get('/admin/workouts/add', [WorkoutController::class, "addbyadmin"], UserType::ADMIN);
$router->get('/admin/products/add', [ProductController::class, "addbyadmin"], UserType::ADMIN);
$router->get('/admin/diet/diets/add', [DietController::class, "addbyadmin"], UserType::ADMIN);
$router->get('/admin/diet/allergies/add', [AllergyController::class, "addbyadmin"], UserType::ADMIN);


$router->post('/admin/recipes/store', [RecipeController::class, "storerecipebyadmin"], UserType::ADMIN);
$router->post('/admin/workouts/store', [WorkoutController::class, "storeworkoutbyadmin"], UserType::ADMIN);
$router->post('/admin/products/store', [ProductController::class, "storeproductbyadmin"], UserType::ADMIN);
$router->post('/admin/diet/diets/store', [DietController::class, "storedietbyadmin"], UserType::ADMIN);
$router->post('/admin/diet/allergies/store', [AllergyController::class, "storeallergybyadmin"], UserType::ADMIN);

<<<<<<< HEAD
$router->post('/admin/recipes/edit', [RecipeController::class, "editrecipebyadmin"], UserType::ADMIN);
$router->post('/admin/workouts/edit', [WorkoutController::class, "editworkoutbyadmin"], UserType::ADMIN);
$router->post('/admin/products/edit', [ProductController::class, "editproductbyadmin"], UserType::ADMIN);
$router->post('/admin/diet/diets/edit', [DietController::class, "editdietbyadmin"], UserType::ADMIN);
$router->post('/admin/diet/allergies/edit', [AllergyController::class, "editallergybyadmin"], UserType::ADMIN);

$router->post('/admin/recipes/update', [RecipeController::class, "updaterecipebyadmin"], UserType::ADMIN);
$router->post('/admin/workouts/update', [WorkoutController::class, "updateworkoutbyadmin"], UserType::ADMIN);
$router->post('/admin/products/update', [ProductController::class, "updateproductbyadmin"], UserType::ADMIN);
$router->post('/admin/diet/diets/update', [DietController::class, "updatedietbyadmin"], UserType::ADMIN);
$router->post('/admin/diet/allergies/update', [AllergyController::class, "updateallergybyadmin"], UserType::ADMIN);
=======
$router->get('/admin/diet/diets/addlist', [DietController::class, "addlistbyadmin"], UserType::ADMIN);
$router->get('/admin/diet/allergies/addlist', [AllergyController::class, "addlistbyadmin"], UserType::ADMIN);
$router->get('/admin/recipes/edit', [RecipeController::class, "editbyadmin"], UserType::ADMIN);
$router->get('/admin/workouts/edit', [WorkoutController::class, "editbyadmin"], UserType::ADMIN);
$router->get('/admin/products/edit', [ProductController::class, "editbyadmin"], UserType::ADMIN);
$router->get('/admin/diet/diets/edit', [DietController::class, "editbyadmin"], UserType::ADMIN);
$router->get('/admin/diet/allergies/edit', [AllergyController::class, "editbyadmin"], UserType::ADMIN);

$router->get('/admin/diet/diets/storelist', [DietController::class, "addlistbyadmin"], UserType::ADMIN);
$router->get('/admin/diet/allergies/storelist', [AllergyController::class, "addlistbyadmin"], UserType::ADMIN);
$router->put('/admin/recipes/update', [RecipeController::class, "updaterecipebyadmin"], UserType::ADMIN);
$router->put('/admin/workouts/update', [WorkoutController::class, "updateworkoutbyadmin"], UserType::ADMIN);
$router->put('/admin/products/update', [ProductController::class, "updateproductbyadmin"], UserType::ADMIN);
$router->put('/admin/diet/diets/update', [DietController::class, "updatedietbyadmin"], UserType::ADMIN);
$router->put('/admin/diet/allergies/update', [AllergyController::class, "updateallergybyadmin"], UserType::ADMIN);
>>>>>>> d2863a5 (first commit)

$router->delete('/admin/recipes/delete', [RecipeController::class, "deleterecipebyadmin"], UserType::ADMIN);
$router->delete('/admin/workouts/delete', [WorkoutController::class, "deleteworkoutbyadmin"], UserType::ADMIN);
$router->delete('/admin/products/delete', [ProductController::class, "deleteproductbyadmin"], UserType::ADMIN);
$router->delete('/admin/diet/diets/delete', [DietController::class, "deletedietbyadmin"], UserType::ADMIN);
$router->delete('/admin/diet/allergies/delete', [AllergyController::class, "deleteallergybyadmin"], UserType::ADMIN);

$router->get('/profile', [UserController::class, "profile"], UserType::LOGINED);

$router->get('/test/forms', [TestController::class, "forms"]);

$router->get('/profile/setting', [UserController::class, "setting"], UserType::LOGINED);
$router->get('/profile/setting/diet', [DietController::class, "choose"], UserType::LOGINED);
$router->get('/profile/setting/norms', [UserController::class, "usernorms"], UserType::LOGINED);
$router->get('/profile/calendar', [MealController::class, "calendar"], UserType::LOGINED);

$router->get('/profile/recipes', [RecipeController::class, "index"], UserType::LOGINED);
$router->get('/profile/products', [ProductController::class, "index"], UserType::LOGINED);
$router->get('/profile/recipes/add', [RecipeController::class, "create"], UserType::LOGINED);
$router->get('/profile/products/add', [ProductController::class, "create"], UserType::LOGINED);
$router->get('/profile/recipes/edit', [RecipeController::class, "edit"], UserType::LOGINED);
$router->get('/profile/products/edit', [ProductController::class, "edit"], UserType::LOGINED);

$router->post('/profile/change_diets', [DietController::class, "changediet"], UserType::LOGINED);
$router->post('/profile/calc_kcal', [UserController::class, "calckcal"], UserType::LOGINED);



// $router->get('/workouts',[WorkoutController::class,"workouts"]);
// $router->get('/workouts/',[MainController::class,"workouts"]);

