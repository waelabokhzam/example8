<?php

use App\Http\Controllers\mealController;
use App\Http\Controllers\paymentsController;
use App\Http\Controllers\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    return $request->user();
});

Route::post('register', [Register::class, 'register']);
Route::post('login', [Register::class, 'login']);
Route::post('loginremotely', [Register::class, 'login_remotely']);
Route::middleware('auth:api')->group(function () {
    Route::resource('post', 'PostController');
    Route::get('get_user', [Register::class, 'get_user']);
    Route::post('check_tabel', 'tabelController@checktabel');
    Route::get('get_tabel', 'tabelController@get_all_tabel');

    Route::get('all_catagory', 'catagoryController@get_catagory');

    Route::get('all_meal/{id}', 'mealController@get_meal');
    Route::get('meal_id/{id}', 'mealController@get_meal_id');

    // route to choise a count of a meal
    Route::post('count_meal/{id}', 'mealController@choise_count_of_meal');

    //get the card
    Route::get('get_card', 'mealController@get_card');
    // edit count of meal
    Route::post('edit_count/{id}', 'mealController@edit_count_meal');
    //Route::get('post/user/{id}', 'PostController@userpost');

    Route::post('lgout', [Register::class, 'logout']); ////////not using yet fro to down :
    //Admin
    Route::post('logoutadmin', [Register::class, 'logoutadmin']);
    Route::get('category/{id}', 'catagoryController@category_id');
    // admin-- add category
    Route::post('add_category', 'catagoryController@addcategory');
    //admin-- edit category
    Route::put('edit_category/{id}', 'catagoryController@editcategory');
    //admin--  add meal
    Route::post('add_meal', 'mealController@addmeal');
    //admin-- edit meal
    Route::put('edit_meal/{id}', 'mealController@editmeal');
    //admin-- user
    Route::get('all_user', [Register::class, 'alluser']);
    //get user that id =requier
    Route::get('get_user/{id}', [Register::class, 'get_user']);
    Route::put('edit_user/{id}', [Register::class, 'edituser']); ///////for this
    //cash monye
    Route::get('cash', [paymentsController::class, 'cash_monye']);
    // check_admin_payment
    Route::get('admin_payment', [paymentsController::class, 'check_admin_payment']);

    Route::get('payment_id/{id}', [paymentsController::class, 'payment_id']);

    //About us
    Route::get('all_members', [mealController::class, 'all_member']);
});
Route::get('prodects', 'PostController@index');

Route::get('get_email/{user_id}', [Register::class, 'get_email']);
//admin add user
Route::post('add_user', [Register::class, 'add_user']);
//admin get rollselect for user
Route::get('get_roll', [Register::class, 'get_roll']);

Route::post('edit_notify', [Register::class, 'edit_notify']);

Route::get('update_chef', [Register::class, 'update_chef']);
Route::get('get_chef_notify', [Register::class, 'get_chef_notify']);
