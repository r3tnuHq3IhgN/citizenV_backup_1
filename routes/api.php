<?php

use App\Http\Controllers\ApiChartController;
use App\Http\Controllers\ApiCityController;
use App\Http\Controllers\ApiCodeController;
use App\Http\Controllers\ApiCommuneController;
use App\Http\Controllers\ApiDistrictController;
use App\Http\Controllers\ApiGpData;
use App\Http\Controllers\ApiHamletController;
use App\Http\Controllers\ApiPopDataController;
use App\Http\Controllers\ApiRegisterController;
use App\Http\Controllers\ApiTimeOpenController;
use App\Http\Controllers\ApiUserController;
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

// POST API
Route::post('/register', [ApiRegisterController::class,'addUser']); 
Route::post('/registerA2', [ApiRegisterController::class,'addUserA2']);
Route::post('/registerA3', [ApiRegisterController::class,'addUserA3']);
Route::post('/registerB1', [ApiRegisterController::class,'addUserB1']);
Route::post('/registerB2', [ApiRegisterController::class,'addUserB2']);

Route::post('/timeopen', [ApiTimeOpenController::class,'timeOpen']);
Route::post('/createcity',[ApiCityController::class, 'createCity']); 
Route::post('/createcommune',[ApiCommuneController::class, 'createCommune']);  
Route::post('/createdistrict',[ApiDistrictController::class, 'createDistrict']);
Route::post('/admincreatecode', [ApiCodeController::class, 'createCode']);
Route::post('createhamlet', [ApiHamletController::class, 'createHamlet']);

Route::post('/popdata', [ApiPopDataController::class, 'insertData']);
 

// GET API 
Route::get('/user/{id}', [ApiUserController::class, 'getUserWithId']);
Route::get('/alluser', [ApiUserController::class,'getUsers']);
Route::get('/userA2', [ApiUserController::class,'getUsersA2']);

Route::get('/removeA2/{email}', [ApiUserController::class,'removeUserA2']);  
Route::get('/updateactive/{code}', [ApiUserController::class,'updateActive']);
Route::get('/updatelock/{code}', [ApiUserController::class,'updateLock']);  

Route::get('/city',[ApiCityController::class, 'getAllCity']);  
Route::get('/city/{city}',[ApiCityController::class, 'getCity']);  
Route::get('/getcityact',[ApiCityController::class, 'getCityAct']);
Route::get('/getcodeofcity/{city}',[ApiCityController::class, 'getCodeOfCity']); 


Route::get('/communes',[ApiCommuneController::class, 'getAllCommunes']);
Route::get('/getcomofdis/{id}',[ApiCommuneController::class, 'getComOfDis']);
Route::get('/getcomofcity/{code}',[ApiCommuneController::class, 'getComOfCity']);
Route::get('/getcomact/{code}',[ApiCommuneController::class, 'getComAct']);
Route::get('/getallcomact',[ApiCommuneController::class, 'getAllComAct']);
Route::get('/comofdis/{dis}', [ApiCommuneController::class, 'comOfDis']); 
Route::get('/getcodeofcom/{com}', [ApiCommuneController::class, 'getCodeOfCom']);
 
Route::get('/district',[ApiDistrictController::class, 'getAllDistrict']);
Route::get('/getdisof/{id}',[ApiDistrictController::class, 'getDisOf']);
Route::get('/disofcity/{city}',[ApiDistrictController::class, 'getDisOfCity']); 
Route::get('/getdisact/{code}',[ApiDistrictController::class, 'getDisAct']);
Route::get('/getalldisact',[ApiDistrictController::class, 'getAllDisAct']);
Route::get('/getcodeofdis/{dis}', [ApiDistrictController::class, 'getCodeOfDis']);



Route::get('/hamlets', [ApiHamletController::class, 'getAllHam']);
Route::get('/gethamofcom/{id}', [ApiHamletController::class, 'getHamOfCom']);
Route::get('/gethamact/{code}', [ApiHamletController::class, 'getHamAct']);
Route::get('/getcodeofham/{ham}', [ApiHamletController::class, 'getCodeOfHam']);


Route::get('/getcode',[ApiCodeController::class, 'getCodeInactive']); 

Route::get('/getcitizen/{code}',[ApiGpData::class, 'getCitizen']);

   
Route::get('/checktime/{code}', [ApiTimeOpenController::class,'checkTime']); 
 
Route::get('/chartallgender', [ApiChartController::class, 'chartGender']);
Route::get('/chartgendermain/{code}', [ApiChartController::class, 'chartGenderMain']);
Route::get('/chartallage', [ApiChartController::class, 'chartAge']);
Route::get('/chartagemain/{code}', [ApiChartController::class, 'chartAgeMain']);

// DELETE API
Route::delete('/deletecom', [ApiCommuneController::class, 'deleteCommune']);
Route::delete('/deleteham', [ApiHamletController::class, 'deleteHamlet']);
Route::delete('/remove/{id}', [ApiUserController::class,'removeUser']);
Route::delete('/deleteopen/{code}', [ApiTimeOpenController::class,'deleteOpen']); 
Route::delete('/removecity/{city}',[ApiCityController::class, 'removeCity']);
Route::delete('/removedistrict',[ApiDistrictController::class, 'removeDis']);  
 