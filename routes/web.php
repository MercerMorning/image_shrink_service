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

//Route::group(['middleware' => ['jwt.verify']], function() {
    Route::match(['get', 'post'], '/optimize', 'ImageController@optimize')->name('uploadImage');
//});

Route::get('{vue_capture?}', function () {
    return view('welcome');
})->where('vue_capture', '[\/\w\.-]*');


//Route::match(['get', 'post'], '/optimize', 'ImageController@optimize')->name('uploadImage');
//Route::match(['get', 'post'], '/optimize', 'ImageController@optimize')->name('uploadImage');
//Route::get('/', 'ImageController@optimize')->name('uploadImage');
//Route::get('/', function () {
//    dd(123);
//});
//Route::view('/', 'welcome')->name('home');
#Route::view('/registration', 'auth.register')->name('registration');

