<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
  'uses' => 'LoginController@index',
  'as' => 'login.index'
]);

Route::post('/login', [
  'uses' => 'LoginController@login',
  'as' => 'user.login'
])->middleware('web');

Route::get('/logout', [
  'uses' => 'LoginController@logout',
  'as' => 'user.logout'
])->middleware('session');

Route::get('/dashboard', [
  'uses' => 'DashboardController@index',
  'as' => 'dashboard.index'
])->middleware('auth');

Route::get('/akun/admin', [
    'uses' => 'AdminController@index',
    'as' => 'admin.index'
])->middleware('auth');

Route::post('/akun/admin/store', [
  'uses' => 'AdminController@store',
  'as' => 'admin.store'
])->middleware('auth');

Route::get('/arsip/kategori', [
    'uses' => 'KategoriArsipController@index',
    'as' => 'kategori.index'
])->middleware('auth');
