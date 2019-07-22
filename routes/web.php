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

Route::get('/welcomeAdmin', function () {
    return view('welcomeAdmin');
});

Route::post('register', function () {
    return view('registration.create');
});

Route::post('api/login','UserController@authenticate');

Route::get('api/login', function () {
    return view('login');
});
Route::get('api/users/index', 'UserController@index');
Route::post('api/users/create', 'UserController@createAdmin');

Route::get('api/plans/index', 'PlanController@showAll');
Route::post('api/plans/create', 'PlanController@create');
Route::post('api/plans/store', 'PlanController@store');
Route::post('api/plans/assignToCategory/{id}', 'PlanController@assignToCategory');

Route::get('api/admins/index', 'UserController@index');

Route::delete('api/users/delete/{id}', 'UserController@destroy');
Route::delete('api/plans/delete/{id}', 'PlanController@delete');

Route::post('api/plans/approve/{id}', 'PlanController@approve');

Route::resource('categories', 'CategoryController');
//Route::resource('users', 'UserController');
Route::post('api/plans/update/{plan}','PlanController@update');
Route::resource('superAdmin', 'UserController');

Route::resource('plans', 'PlanController');
//Route::match(['PUT','PATCH'],'api/plans/update/{id}','PlanController@update');
