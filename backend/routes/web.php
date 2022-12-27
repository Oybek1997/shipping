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
Route::get('/forGaraj{gNumner}/{sdate}/{edate}', 'VehicleController@forGaraj');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/updatemodel', 'TestController@updatemodelname');

//Route::group(['middleware' => ['auth']], function () {
//    Route::post('delete-all', 'VehicleController@deleteFunction');
//});
