<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Project
Route::get('/projects','ProjectController@index');
Route::post('/projects/store', 'ProjectController@store');
Route::patch('/projects/update/{id}', 'ProjectController@update');
Route::delete('/projects/delete/{id}', 'ProjectController@destroy');
Route::get('/projects/show/{id}', 'ProjectController@showByID');
//Job
Route::get('/jobs','JobController@index');
Route::post('/jobs/store','JobController@store');
Route::patch('/jobs/update/{id}', 'JobController@update');
Route::delete('/jobs/delete/{id}','JobController@destroy');
Route::get('/jobs/show/{id}', 'JobController@show');
//Material
Route::get('/materials','MaterialsController@index');
Route::post('/materials/store','MaterialsController@store');
Route::patch('/materials/update/{id}', 'MaterialsController@update');
Route::delete('/materials/delete/{id}','MaterialsController@destroy');
Route::get('/materials/show/{id}', 'MaterialsController@show');
//AHS 
Route::get('/ahs','AHSController@index');
Route::post('/ahs/store','AHSController@store');
Route::patch('/ahs/update/{id}','AHSController@update');
Route::delete('/ahs/delete/{id}','AHSController@destroy');
//AHS Details
Route::get('/ahs_details','AHSDetailsController@index');
//Material Details
Route::get('/material_details','MaterialDetailsController@index');
Route::post('/material_details/store','MaterialDetailsController@store');
//RAB
Route::get('/rabs','RABController@index');
Route::post('/rabs/store','RABController@store');
Route::patch('/rabs/update/{id}','RABController@update');
Route::delete('/rabs/delete/{id}','RABController@destroy');
//RAB Details
Route::get('/rab_details','RABDetailsController@index');