<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;




//===========================REGISTRATION & LOGIN PAGE================================//
Route::get('/','App\Http\Controllers\AuthController@restart');
Route::get('/register','App\Http\Controllers\AuthController@start');
Route::post('/register','App\Http\Controllers\AuthController@register');
Route::get('/getUser','App\Http\Controllers\AuthController@getUser');
Route::post('/add-user','App\Http\Controllers\AuthController@store');
Route::post('/updateUser','App\Http\Controllers\AuthController@updateUser');
Route::get('/delete-user/{id}','App\Http\Controllers\AuthController@deleteUser');

Route::get('/login','App\Http\Controllers\AuthController@restart');
Route::post('/login','App\Http\Controllers\AuthController@login');
Route::get('/logout','App\Http\Controllers\AuthController@logout');


//===========================INDEX PAGE================================//
Route::get('/index','App\Http\Controllers\GoodsController@index');
Route::post('/add-item','App\Http\Controllers\GoodsController@add');
Route::post('/add-itemtype','App\Http\Controllers\GoodsController@addtype');
Route::get('/get-item','App\Http\Controllers\GoodsController@show');
Route::get('/getitemtype','App\Http\Controllers\GoodsController@show2');
Route::post('/update-item','App\Http\Controllers\GoodsController@edit');
Route::post('/additem','App\Http\Controllers\GoodsController@additem');
Route::post('/takeitem','App\Http\Controllers\GoodsController@takeitem');
Route::get('/delete-item/{id}','App\Http\Controllers\GoodsController@destory');


//===========================USER PAGE================================//
Route::get('/user-requests','App\Http\Controllers\UserController@showRequests');
Route::get('/getrequest','App\Http\Controllers\UserController@getrequest');
Route::post('/submit-request' ,'App\Http\Controllers\UserController@submitRequest');


//===========================MANAGER PAGE================================//
Route::get('/manager-requests','App\Http\Controllers\ManagerController@showRequests');
Route::post('/approve-request/{id}', 'App\Http\Controllers\ManagerController@approveRequest'); 
Route::post('/reject-request/{id}', 'App\Http\Controllers\ManagerController@rejectRequest');   

