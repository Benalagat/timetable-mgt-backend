<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\WeekGoalsController;
use Illuminate\Routing\MiddlewareNameResolver;
use App\Http\Controllers\ProjectUsersController;


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
//  Route::middleware(['auth', 'user'])->group(function () {
//        Route::controller(RolesController::class)->group(function (){
//
//        Route::post('addroles',  'store')->where('name','superadmin');
//        Route::get('getroles','list')->where('name',['admin','superadmin']);
//
//        });
//    });

    Route::get('user-auth',[UsersController::class,'auth']);

    Route::get('show_admins',[UsersController::class,'show_admins']);
    Route::get('show_users',[UsersController::class,'show_users']);
    Route::post('users/update-user/{id}',[UsersController::class,'update_user']);
    Route::post('tasks',[TasksController::class,'store']);
    Route::get('show-tasks',[TasksController::class,'show']);
    Route::post('addReview',[ReviewsController::class,'store']);

    Route::get('get-reviews',[TasksController::class,'get_reviews']);
    Route::get('mark_completed/{id}',[TasksController::class,'mark_completed']);

    Route::get('edit-tasks/{id}',[TasksController::class,'edit']);

    Route::get('logout',[UsersController::class, 'logout']);
    Route::post('create_users',[UsersController::class, 'registerAdmin']);

     Route::post('addroles',[RolesController::class,'store']);
     Route::get('getroles',[RolesController::class,'list']);


     Route::post('addprojects/{project_id?}',[ProjectsController::class,'store']);
     Route::get('getprojects',[ProjectsController::class,'listProjects']);
     Route::get('fetch_overview/{id}',[ProjectsController::class,'fetch_overview']);

     Route::post('assignuserproject', [ProjectUsersController::class, 'addUserToProject']);
     Route::get('unassignedUsers',[ProjectUsersController::class,'unassignedUsers']);


});

Route::post('update-tasks/{id}',[TasksController::class,'updateone']);

Route::post('register',[UsersController::class, 'store']);
Route::post('login',[UsersController::class, 'login']);
Route::post('reset_password',[UsersController::class, 'reset_password']);
Route::post('change_password/{id}',[UsersController::class, 'change_password']);


Route::post('tasks/{id}',[TasksController::class,'update']);
Route::delete('tasks/{id}',[TasksController::class,'destroy']);

Route::post('weekoals',[WeekGoalsController::class,'store']);
Route::get('showWeekoals',[WeekGoalsController::class,'show']);
Route::get('getRandomWeekGoal',[WeekGoalsController::class,'getRandomWeekGoal']);


