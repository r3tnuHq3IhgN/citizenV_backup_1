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
    return view('home');
});
Route::get('/admin', function(){ 
    return view('admin');
})->name('admin')->middleware('roleadmin');
Route::get('/a1', function(){ 
    return view('a1');
})->name('a1')->middleware('rolea1');
Route::get('/a2', function(){ 
    return view('a2');
})->name('a2')->middleware('rolea2');

Route::get('/a3', function(){ 
    return view('a3');
})->name('a3')->middleware('rolea3');

Route::get('/b1', function(){ 
    return view('b1');
})->name('b1')->middleware('roleb1'); 

Route::get('/b2', function(){ 
    return view('b2');
})->name('b2')->middleware('roleb2'); 
Auth::routes();    

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
