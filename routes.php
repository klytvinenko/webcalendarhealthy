<?php

use App\Controllers\RecipeController;
use App\Controllers\TestController;
use App\Controllers\UserController;
use App\Controllers\ProductController;
use App\Controllers\DietController;
use App\Controllers\AllergyController;
use App\Controllers\WorkoutController;
use App\Controllers\MealController;
use App\Controllers\WeightController;
use App\UserType;

//auth
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
//show
$router->get('/admin/recipes/show', [RecipeController::class, "showbyadmin"], UserType::ADMIN);
$router->get('/admin/workouts/show', [WorkoutController::class, "showbyadmin"], UserType::ADMIN);
$router->get('/admin/products/show', [ProductController::class, "showbyadmin"], UserType::ADMIN);
//approve
$router->get('/admin/recipes/approve', [RecipeController::class, "approve"], UserType::ADMIN);
$router->get('/admin/workouts/approve', [WorkoutController::class, "approve"], UserType::ADMIN);
$router->get('/admin/products/approve', [ProductController::class, "approve"], UserType::ADMIN);
// replace
$router->get('/admin/recipes/replace', [RecipeController::class, "replace"], UserType::ADMIN);
$router->get('/admin/workouts/replace', [WorkoutController::class, "replace"], UserType::ADMIN);
$router->get('/admin/products/replace', [ProductController::class, "replace"], UserType::ADMIN);
// add
$router->get('/admin/diet/diets/add', [DietController::class, "addbyadmin"], UserType::ADMIN);
$router->get('/admin/diet/allergies/add', [AllergyController::class, "addbyadmin"], UserType::ADMIN);
$router->get('/admin/recipes/add', [RecipeController::class, "addbyadmin"], UserType::ADMIN);
$router->get('/admin/workouts/add', [WorkoutController::class, "addbyadmin"], UserType::ADMIN);
$router->get('/admin/products/add', [ProductController::class, "addbyadmin"], UserType::ADMIN);
// store
$router->post('/admin/recipes/store', [RecipeController::class, "storerecipebyadmin"], UserType::ADMIN);
$router->post('/admin/workouts/store', [WorkoutController::class, "storeworkoutbyadmin"], UserType::ADMIN);
$router->post('/admin/products/store', [ProductController::class, "storeproductbyadmin"], UserType::ADMIN);
$router->post('/admin/diet/diets/store', [DietController::class, "storedietbyadmin"], UserType::ADMIN);
$router->post('/admin/diet/allergies/store', [AllergyController::class, "storeallergybyadmin"], UserType::ADMIN);
// edit
$router->get('/admin/recipes/edit', [RecipeController::class, "editbyadmin"], UserType::ADMIN);
$router->get('/admin/workouts/edit', [WorkoutController::class, "editbyadmin"], UserType::ADMIN);
$router->get('/admin/products/edit', [ProductController::class, "editbyadmin"], UserType::ADMIN);
$router->get('/admin/diet/diets/edit', [DietController::class, "editbyadmin"], UserType::ADMIN);
$router->get('/admin/diet/allergies/edit', [AllergyController::class, "editbyadmin"], UserType::ADMIN);
// storelist
$router->get('/admin/diet/diets/storelist', [DietController::class, "addlistbyadmin"], UserType::ADMIN);
$router->get('/admin/diet/allergies/storelist', [AllergyController::class, "addlistbyadmin"], UserType::ADMIN);
$router->put('/admin/recipes/update', [RecipeController::class, "updaterecipebyadmin"], UserType::ADMIN);
$router->put('/admin/workouts/update', [WorkoutController::class, "updateworkoutbyadmin"], UserType::ADMIN);
$router->put('/admin/products/update', [ProductController::class, "updateproductbyadmin"], UserType::ADMIN);
$router->put('/admin/diet/diets/update', [DietController::class, "updatedietbyadmin"], UserType::ADMIN);
$router->put('/admin/diet/allergies/update', [AllergyController::class, "updateallergybyadmin"], UserType::ADMIN);

$router->delete('/admin/recipes/delete', [RecipeController::class, "deleterecipebyadmin"], UserType::ADMIN);
$router->delete('/admin/workouts/delete', [WorkoutController::class, "deleteworkoutbyadmin"], UserType::ADMIN);
$router->delete('/admin/products/delete', [ProductController::class, "deleteproductbyadmin"], UserType::ADMIN);
$router->delete('/admin/diet/diets/delete', [DietController::class, "deletedietbyadmin"], UserType::ADMIN);
$router->delete('/admin/diet/allergies/delete', [AllergyController::class, "deleteallergybyadmin"], UserType::ADMIN);

//index
$router->get('/profile', [UserController::class, "profile"], UserType::LOGINED);
//setting
$router->get('/profile/setting', [UserController::class, "setting"], UserType::LOGINED);
$router->get('/profile/setting/diet', [DietController::class, "choose"], UserType::LOGINED);
$router->get('/profile/setting/norms', [UserController::class, "usernorms"], UserType::LOGINED);
$router->post('/profile/change_diets', [DietController::class, "changediet"], UserType::LOGINED);
$router->post('/profile/calc_kcal', [UserController::class, "calckcal"], UserType::LOGINED);
//calendar
$router->get('/profile/calendar', [MealController::class, "calendar"], UserType::LOGINED);
$router->get('/profile/day', [MealController::class, "day"], UserType::LOGINED);

$router->get('/profile/recipes', [RecipeController::class, "index"], UserType::LOGINED);
$router->get('/profile/workouts', [WorkoutController::class, "index"], UserType::LOGINED);
$router->get('/profile/products', [ProductController::class, "index"], UserType::LOGINED);
//show
$router->get('/profile/recipes/show', [RecipeController::class, "show"], UserType::LOGINED);
$router->get('/profile/products/show', [ProductController::class, "show"], UserType::LOGINED);
$router->get('/profile/workouts/show', [WorkoutController::class, "show"], UserType::LOGINED);
// add
$router->get('/profile/recipes/add', [RecipeController::class, "add"], UserType::LOGINED);
$router->get('/profile/workouts/add', [WorkoutController::class, "add"], UserType::LOGINED);
$router->get('/profile/products/add', [ProductController::class, "add"], UserType::LOGINED);
// edit
$router->get('/profile/recipes/edit', [RecipeController::class, "edit"], UserType::LOGINED);
$router->get('/profile/products/edit', [ProductController::class, "edit"], UserType::LOGINED);
$router->get('/profile/workouts/edit', [WorkoutController::class, "edit"], UserType::LOGINED);
// store
$router->post('/profile/weights/store', [WeightController::class, "storeweigth"], UserType::LOGINED);
$router->post('/profile/recipes/store', [RecipeController::class, "storerecipe"], UserType::LOGINED);
$router->post('/profile/workouts/store', [WorkoutController::class, "storeworkout"], UserType::LOGINED);
$router->post('/profile/products/store', [ProductController::class, "storeproduct"], UserType::LOGINED);
// generatemenu
$router->put('/profile/meals/generate', [MealController::class, "generatemenu"], UserType::LOGINED);
// updatew
$router->put('/profile/workouts/update', [WorkoutController::class, "updateworkout"], UserType::LOGINED);
$router->put('/profile/recipes/update', [RecipeController::class, "updaterecipe"], UserType::LOGINED);
$router->put('/profile/products/update', [ProductController::class, "updateproduct"], UserType::LOGINED);
// like
$router->get('/profile/recipes/like', [RecipeController::class, "like"], UserType::LOGINED);
$router->get('/profile/products/like', [ProductController::class, "like"], UserType::LOGINED);
//delete
$router->delete('/profile/workouts/delete', [WorkoutController::class, "deleteworkout"], UserType::LOGINED);
$router->delete('/profile/workouts_user/delete', [WorkoutController::class, "deleteworkoutuser"], UserType::LOGINED);
$router->delete('/profile/recipes/delete', [RecipeController::class, "deleterecipe"], UserType::LOGINED);
$router->delete('/profile/products/delete', [ProductController::class, "deleteproduct"], UserType::LOGINED);
$router->get('/profile/meals/delete', [MealController::class, "deletemeal"], UserType::LOGINED);
$router->delete('/profile/workoutsuser/delete', [WorkoutController::class, "deleteworkoutuser"], UserType::LOGINED);
// for calendar
$router->post('/profile/meals/generate', [MealController::class, "generatemenu"], UserType::LOGINED);
$router->post('/profile/calendar/workouts/store', [WorkoutController::class, "storeworkoutfromcalendar"], UserType::LOGINED);
$router->post('/profile/calendar/weights/store', [WeightController::class, "storeweigthfromcalendar"], UserType::LOGINED);



