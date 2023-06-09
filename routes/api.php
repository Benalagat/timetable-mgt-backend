<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\WeekGoalsController;
use Illuminate\Routing\MiddlewareNameResolver;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user() ;
});


Route::group(['middleware' => ['auth:sanctum']],function (){


    
    Route::middleware(['auth', 'user'])->group(function () {
        Route::controller(RolesController::class)->group(function (){
        Route::post('addroles',  'store')->where('name', 'superadmin');
        Route::get('getroles','list')->where('name',['superadmin','admin']);

        Route::controller(TasksController::class)->group(function (){
            Route::post('tasks',  'store')->where('name', 'admin');
            Route::get('show-tasks','show')->where('name', ['admin','superadmin']);
        });   
    });
       
});

    Route::get('user-auth',[UsersController::class,'user']);

    // Route::post('tasks',[TasksController::class,'store']);
    // Route::get('show-tasks',[TasksController::class,'show']);

    Route::post('addReview',[ReviewsController::class,'store']);

    Route::get('get-reviews',[TasksController::class,'get_reviews']);
    Route::get('mark_completed/{id}',[TasksController::class,'mark_completed']);

    Route::get('edit-tasks/{id}',[TasksController::class,'edit']);

    Route::get('logout',[UsersController::class, 'logout']);

    // Route::post('addroles',[RolesController::class,'store']);
    // Route::get('getroles',[RolesController::class,'list']);
});

Route::post('update-tasks/{id}',[TasksController::class,'updateone']);

Route::post('register',[UsersController::class, 'store']);
Route::post('login',[UsersController::class, 'login']);


Route::post('tasks/{id}',[TasksController::class,'update']);
Route::delete('tasks/{id}',[TasksController::class,'destroy']);

Route::post('weekoals',[WeekGoalsController::class,'store']);
Route::get('showWeekoals',[WeekGoalsController::class,'show']);
Route::get('getRandomWeekGoal',[WeekGoalsController::class,'getRandomWeekGoal']);


