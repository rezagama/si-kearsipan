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
]);

Route::get('/logout', [
  'uses' => 'LoginController@logout',
  'as' => 'user.logout'
]);

Route::get('/dashboard', [
  'uses' => 'DashboardController@index',
  'as' => 'dashboard.index'
]);

Route::get('/arsip/kategori', [
    'uses' => 'KategoriArsipController@index',
    'as' => 'kategori.index'
]);
