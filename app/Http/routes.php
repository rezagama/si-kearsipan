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
])->middleware('guest');

Route::post('/login', [
  'uses' => 'LoginController@login',
  'as' => 'user.login'
]);

Route::get('/logout', [
  'uses' => 'LoginController@logout',
  'as' => 'user.logout'
])->middleware('session');

Route::get('/beranda/pengumuman', [
  'uses' => 'PengumumanController@home',
  'as' => 'pengumuman.list'
]);

Route::get('/beranda/pengumuman/{id}/post', [
  'uses' => 'PengumumanController@post',
  'as' => 'pengumuman.post'
]);

Route::group(['middleware' => ['auth', 'status']], function () {
  Route::get('/dashboard', [
    'uses' => 'DashboardController@index',
    'as' => 'dashboard.index'
  ]);

  Route::get('akun/{id}/profil', [
    'uses' => 'AccountController@show',
    'as' => 'account.show'
  ]);

  Route::get('akun/{id}/edit', [
    'uses' => 'AccountController@edit',
    'as' => 'account.edit'
  ]);

  Route::post('akun/{id}/update', [
    'uses' => 'AccountController@update',
    'as' => 'account.update'
  ]);

  Route::get('/akun/staff', [
      'uses' => 'StaffController@index',
      'as' => 'staff.index'
  ]);

  Route::post('/akun/staff/store', [
    'uses' => 'StaffController@store',
    'as' => 'staff.store'
  ]);

  Route::get('/arsip/folder', [
    'uses' => 'ArsipController@index',
    'as' => 'arsip.index'
  ]);

  Route::get('/arsip/{id}/folder', [
    'uses' => 'ArsipController@show',
    'as' => 'arsip.show'
  ]);

  Route::get('/arsip/folder/{id}/dokumen', [
    'uses' => 'ArsipController@dokumen',
    'as' => 'arsip.dokumen'
  ]);

  Route::post('/arsip/folder/dokumen/store', [
    'uses' => 'ArsipController@store',
    'as' => 'arsip.store'
  ]);

  Route::get('/arsip/folder/dokumen/{id}/download', [
    'uses' => 'ArsipController@download',
    'as' => 'arsip.download'
  ]);

  Route::get('/arsip/folder/dokumen/{id}/detail', [
    'uses' => 'ArsipController@detail',
    'as' => 'arsip.detail'
  ]);

  Route::get('/arsip/folder/dokumen/{id}/edit', [
    'uses' => 'ArsipController@edit',
    'as' => 'arsip.edit'
  ]);

  Route::post('/arsip/folder/dokumen/{id}/update', [
    'uses' => 'ArsipController@update',
    'as' => 'arsip.update'
  ]);

  Route::get('/riwayat/aktifitas', [
    'uses' => 'LogController@index',
    'as' => 'log.index'
  ]);

  Route::get('/pesan/masuk', [
    'uses' => 'PesanController@pesanmasuk',
    'as' => 'pesan.masuk'
  ]);

  Route::get('/pesan/terkirim', [
    'uses' => 'PesanController@pesankeluar',
    'as' => 'pesan.keluar'
  ]);

  Route::get('/pesan/{id}/detail', [
    'uses' => 'PesanController@show',
    'as' => 'pesan.show'
  ]);

  Route::post('/pesan/{id}/kirim', [
    'uses' => 'PesanController@balas',
    'as' => 'pesan.balas'
  ]);

  Route::get('/pesan/tulis', [
    'uses' => 'PesanController@compose',
    'as' => 'pesan.compose'
  ]);

  Route::post('/pesan/kirim/baru', [
    'uses' => 'PesanController@store',
    'as' => 'pesan.store'
  ]);

  Route::get('/pesan/{id}/edit', [
    'uses' => 'PesanController@edit',
    'as' => 'pesan.edit'
  ]);

  Route::post('/pesan/{id}/update', [
    'uses' => 'PesanController@update',
    'as' => 'pesan.update'
  ]);

  Route::delete('/pesan/{id}/delete', [
    'uses' => 'PesanController@delete',
    'as' => 'pesan.delete'
  ]);

  Route::get('/pengumuman', [
    'uses' => 'PengumumanController@index',
    'as' => 'pengumuman.index'
  ]);

  Route::get('/pengumuman/baru', [
    'uses' => 'PengumumanController@compose',
    'as' => 'pengumuman.compose'
  ]);

  Route::get('/pengumuman/{id}/detail', [
    'uses' => 'PengumumanController@show',
    'as' => 'pengumuman.show'
  ]);

  Route::post('/pengumuman/store', [
    'uses' => 'PengumumanController@store',
    'as' => 'pengumuman.store'
  ]);

  Route::post('/pengumuman/{id}/update', [
    'uses' => 'PengumumanController@update',
    'as' => 'pengumuman.update'
  ]);

  Route::get('/pengumuman/{id}/edit', [
    'uses' => 'PengumumanController@edit',
    'as' => 'pengumuman.edit'
  ]);

  Route::delete('/pengumuman/{id}/delete', [
    'uses' => 'PengumumanController@delete',
    'as' => 'pengumuman.delete'
  ]);

  Route::get('/statistik', [
    'uses' => 'StatistikController@index',
    'as' => 'statistik.index'
  ]);

  Route::get('/statistik/jenis/arsip', [
    'uses' => 'StatistikController@jumlaharsip',
    'as' => 'statistik.jumlaharsip'
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

  Route::get('/direktori/arsip', [
      'uses' => 'DirektoriController@index',
      'as' => 'direktori.index'
  ]);

  Route::get('/direktori/arsip/folder/', [
      'uses' => 'DirektoriController@index',
      'as' => 'direktori.index'
  ]);

  Route::get('/direktori/arsip/{id}/folder', [
      'uses' => 'DirektoriController@show',
      'as' => 'direktori.show'
  ]);

  Route::post('/direktori/arsip/folder/store', [
      'uses' => 'DirektoriController@store',
      'as' => 'direktori.store'
  ]);

  Route::post('/direktori/arsip/folder/update', [
      'uses' => 'DirektoriController@update',
      'as' => 'direktori.update'
  ]);

  Route::delete('/direktori/arsip/folder/hapus', [
      'uses' => 'DirektoriController@destroy',
      'as' => 'direktori.hapus'
  ]);

  Route::delete('/arsip/folder/dokumen/{id}/hapus', [
    'uses' => 'ArsipController@destroy',
    'as' => 'arsip.hapus'
  ]);
});
