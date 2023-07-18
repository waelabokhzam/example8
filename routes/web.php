<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});
Route::get('image', 'PostController@image');

Route::get('r_image', 'PostController@r_image');
Route::get('manycatagory', 'PostController@manycatagory');
Route::get('meal_inventory', 'PostController@meal_inventory');
Route::get('inventory_meal', 'PostController@inventory_meal');
Route::get('tt', 'tabelController@get_all_tabel');
Route::get('meal_id/{id}', 'mealController@get_meal_id');

Route::get('uploadfile', 'imageController@index');
Route::post('upload_file', 'imageController@create')->name('uploadImage');
Route::get('all', 'imageController@allimage');
Route::get('get_card', 'mealController@get_card');
Route::get('get_card/{id}', 'mealController@get_card');
