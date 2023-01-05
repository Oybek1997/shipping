<?php
date_default_timezone_set("Asia/Tashkent");

use App\Http\Controllers\DilerWinController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('allFile', 'TestController@getAllFiles');
Route::group(['middleware' => ['auth:api', 'user.log']], function () {

    Route::post('details/get-excel', 'DetailController@getExcel');
    Route::post('report1/get-excel', 'OrderController@getReportExcel');

    Route::post('test', function (Request $request) {
        return Auth::user();
    });
    Route::get('users/show', 'UserController@show');
    Route::get('users', 'UserController@index');
    Route::post('getuser/{tbn}', 'UserController@usercreate');
    Route::post('users/update', 'UserController@update');
    Route::delete('users/delete/{id}', 'UserController@destroy');

    Route::get('roles', 'UserController@getRoles');

    Route::post('user/logs', 'UserLogController@index');
    Route::get('/users/find/{tabel}', 'UserController@findUser');


    Route::post('excel', 'TestController@index');

    Route::post('vehicle-detail', 'VehicleDetailController@index');
    Route::post('monthreport', 'VehicleDetailController@monthreport');
    Route::post('modelreport', 'VehicleDetailController@modelreport');

    //diogrammalar uchun API
    Route::get('apione', 'VehicleDetailController@apiOne');
    Route::get('apitwo', 'VehicleDetailController@apiTwo');
    Route::get('apithree', 'VehicleDetailController@apiThree');
    Route::get('apifour', 'VehicleDetailController@apiFour');
    Route::get('apifive', 'VehicleDetailController@apiFive');

    Route::post('getVehicle', 'VehicleController@index');
    Route::post('getDilerWin', 'DilerWinController@index');

    Route::post('getDiler', 'DilerController@index');
    Route::delete('dilers/delete/{id}', 'DilerController@destroy');

    Route::post('getDilerUser', 'DilerUserController@index');


    Route::post('vehicles/update', 'VehicleController@update');
    Route::delete('vehicles/delete/{id}', 'VehicleController@destroy');
    Route::post('okVin', 'VehicleController@okVin');
    Route::post('printVin', 'VehicleController@printVin');
    Route::post('printVinAgain', 'VehicleController@printVinAgain');


    Route::post('getDetail', 'DetailController@index');
    Route::post('details/update', 'DetailController@update');
    Route::delete('details/delete/{id}', 'DetailController@destroy');
    Route::post('detailSearch', 'DetailController@detailSearch');
    Route::post('addDetail', 'OrderController@addDetail');
    Route::post('removeDetailFromOrder', 'OrderController@removeDetail');

    Route::post('getWarehouses', 'WarehouseController@index');
    Route::post('warehouses/update', 'WarehouseController@update');
    Route::delete('warehouses/delete/{id}', 'WarehouseController@destroy');

    Route::post('getEmployee', 'EmployeeController@index');
    Route::post('employees/update', 'EmployeeController@update');
    Route::delete('employees/delete/{id}', 'EmployeeController@destroy');

    Route::post('mplImport', 'TestController@mplImport');
    Route::post('mplImportday', 'TestController@mplImportday');
    Route::post('mplImportupdate', 'TestController@mplImportupdate');
    Route::post('mplOk', 'TestController@mplImportok');
    Route::post('mplImportsend', 'TestController@mplImportsend');
    Route::post('details', 'TestController@mplImportdetails');

    Route::post('getPartnumFile', 'TestController@getFile');
    Route::post('report-count', 'OrderController@reportCount');
    Route::post('report-count2', 'OrderController@reportCount2');
    Route::post('report-count3', 'OrderController@reportCount3');
    Route::get('warehouses', 'WarehouseController@warehouses');
    Route::post('android', 'VehicleController@android');
    Route::post('hello', 'VehicleController@vehicles');
    Route::post('users/usercreate', 'UserController@simpleusercreate');


    Route::post('delete-all', 'VehicleController@deleteFunction');
    Route::post('dilers/delete-all', 'DilerController@deleteFunction');
    //    Route::post('delete-all', 'VehicleController@deleteFunction');
    Route::get('getMainData', 'DilerUserController@getMaindata');
    Route::post('dillerUser/add', 'DilerUserController@add');

    Route::post('vehicles/get-excel', 'VehicleController@getExcel');
    Route::post('dilers/get-excel', 'DilerController@getExcel');
    Route::get('dillersdata', 'DilerWinController@dillersdata');
    Route::get('datadate', 'DilerWinController@datedatafc');
    Route::get('datausers', 'DilerWinController@usersdatafc');
});

Route::post('shipping-vehicles', 'VehicleController@vehicles');
Route::post('show-dilers', 'VehicleController@diler');
Route::post('diler-win', 'VehicleController@dilerWin');

