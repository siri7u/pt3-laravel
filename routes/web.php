<?php

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

Route::get('/tests1', function () {
    return view('tests1');
});

Route::get('tests1', 'tests1UploadController@tests1Upload')->name('tests1.upload');
Route::post('tests1', 'tests1UploadController@tests1UploadPost')->name('tests1.upload.post');


Route::get('/tests2', function () {
    return view('tests2');
});

Route::get('user/{id}', function ($id) {
    return 'User '.$id;
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'HomeController@uploadPost')->name('home.upload.post');





