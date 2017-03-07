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

Route::group(['middleware' => ['auth', 'status']], function () {
  Route::get('/dashboard', [
    'uses' => 'DashboardController@index',
    'as' => 'dashboard.index'
  ]);
});

Route::group(['middleware' => ['auth', 'admin', 'status']], function () {
  Route::get('/akun/admin', [
      'uses' => 'AdminController@index',
      'as' => 'admin.index'
  ]);

  Route::post('/akun/admin/store', [
    'uses' => 'AdminController@store',
    'as' => 'admin.store'
  ]);

  Route::post('/akun/admin/update/{id}/status/{status}', [
    'uses' => 'AdminController@status',
    'as' => 'admin.status'
  ]);

  Route::post('/akun/admin/update/{id}/level/{level}', [
    'uses' => 'AdminController@level',
    'as' => 'admin.level'
  ]);

  Route::delete('/akun/admin/hapus/{id}', [
    'uses' => 'AdminController@destroy',
    'as' => 'admin.destroy'
  ]);

  Route::get('/arsip/kategori', [
      'uses' => 'KategoriArsipController@index',
      'as' => 'kategori.index'
  ]);
});
