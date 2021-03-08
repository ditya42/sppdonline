<?php

Auth::routes();
Route::post('/login','Auth\LoginController@login')->name('login');
Route::post('/logout','Auth\LoginController@logout')->name('logout');

Route::get('/','HomeController@index')->name('dashboard')->middleware(['web','role:Super Admin|Admin SKPD|Admin Bidang|Pegawai']);
Route::get('/home','HomeController@index')->name('dashboard')->middleware(['web','role:Super Admin|Admin SKPD|Admin Bidang|Pegawai']);
Route::get('/profile','HomeController@profile')->name('profile')->middleware(['web','role:Super Admin|Admin SKPD|Admin Bidang|Pegawai']);
Route::put('/updateprofile/{id}','HomeController@updateprofile')->name('updateprofile')->middleware(['web','role:Super Admin|Admin SKPD|Admin Bidang|Pegawai']);

Route::group(['middleware' => ['web','role:Super Admin']] , function() {
  Route::namespace('SuperAdmin\Master')->group(function () {

    Route::get('/jenistransportas/data','JenisTransportasiController@data')->name('jenistransportasi.data');
    Route::resource('jenistransportasi','JenisTransportasiController');

    Route::get('/jenisangkutan/data','JenisAngkutanController@data')->name('jenisangkutan.data');
    Route::resource('jenisangkutan','JenisAngkutanController');

    Route::get('superadmin/jenissurat/data','JenisSuratController@data')->name('superadminjenissurat.data');
    Route::resource('superadmin/jenissurat','JenisSuratController',['as' => 'superadmin']);

    Route::get('Superadmin/dasarsurat/data','DasarController@data')->name('superadmindasarsurat.data');
    Route::resource('superadmin/dasarsurat','DasarController', ['as' => 'superadmin']);
  });

  Route::namespace('SuperAdmin')->group(function () {
    Route::get('/manajemenuser/apipegawai','ManajemenUserController@apipegawai')->name('manajemenuser.apipegawai');
    Route::get('/manajemenuser/data','ManajemenUserController@data')->name('manajemenuser.data');
    Route::resource('manajemenuser','ManajemenUserController');
  });

});

Route::group(['middleware' => ['web','role:Admin SKPD']] , function() {
  Route::namespace('AdminSKPD\Master')->group(function () {
    Route::get('/bidang/data','BidangController@data')->name('bidang.data');
    Route::get('/bidang/datatrash','BidangController@datatrash')->name('bidang.datatrash');
    Route::post('/bidang/hapus/{id}','BidangController@hapus')->name('bidang.hapus');
    Route::post('/bidang/hapuspermanent/{id}','BidangController@hapuspermanent')->name('bidang.hapuspermanent');
    Route::post('/bidang/restore/{id}','BidangController@restore')->name('bidang.restore');
    Route::get('/bidang/trash','BidangController@trash')->name('bidang.trash');
    Route::resource('bidang','BidangController');

    Route::get('adminskpd/jenissurat/data','JenisSuratAdminSKPDController@data')->name('adminskpdjenissurat.data');
    Route::resource('adminskpd/jenissurat','JenisSuratAdminSKPDController', ['as' => 'adminskpd']);

    Route::get('adminskpd/dasarsurat/data','DasarAdminSKPDController@data')->name('adminskpddasarsurat.data');
    Route::resource('adminskpd/dasarsurat','DasarAdminSKPDController', ['as' => 'adminskpd']);
  });

  Route::namespace('AdminSKPD\Pegawai')->group(function () {
    Route::get('/pegawai/data','PegawaiController@data')->name('pegawai.data');
    Route::get('/pegawai/datasubunit','PegawaiController@datasubunit')->name('pegawai.datasubunit');
    Route::resource('pegawai','PegawaiController');

    Route::get('/pegawaikontrak/data','PegawaiKontrakController@data')->name('pegawaikontrak.data');
    Route::resource('pegawaikontrak','PegawaiKontrakController');
  });

  Route::namespace('AdminSKPD')->group(function () {
    Route::get('/manajemenuseradmin/apipegawai','ManajemenUserAdminController@apipegawai')->name('manajemenuseradmin.apipegawai');
    Route::get('/manajemenuseradmin/data','ManajemenUserAdminController@data')->name('manajemenuseradmin.data');
    Route::post('/manajemenuseradmin/hapus/{id}','ManajemenUserAdminController@hapus')->name('manajemenuseradmin.hapus');
    Route::resource('manajemenuseradmin','ManajemenUserAdminController');

    Route::resource('notadinas','NotaDinasController');
  });


});


Route::group(['middleware' => ['web','role:Pegawai']] , function() {
    Route::namespace('Pegawai\Master')->group(function () {

      Route::get('user/jenissurat/data','JenisSuratPegawaiController@data')->name('pegawaijenissurat.data');
      Route::resource('user/jenissurat','JenisSuratPegawaiController', ['as' => 'pegawai']);

      Route::get('user/dasarsurat/data','DasarPegawaiController@data')->name('pegawaidasarsurat.data');
      Route::resource('user/dasarsurat','DasarPegawaiController', ['as' => 'pegawai']);
    });

    Route::namespace('Pegawai')->group(function () {
        Route::get('user/notadinas/pegawaiberangkat/data','PegawaiBerangkatController@data')->name('pegawaiberangkat.data');
        Route::get('user/notadinas/pegawaiberangkat/{id}','PegawaiBerangkatController@index')->name('pegawaiberangkat');
        Route::post('user/notadinas/pegawaiberangkat','PegawaiBerangkatController@store')->name('pegawaiberangkat.store');


        Route::get('user/notadinas/apijabatan/','NotaDinasPegawaiController@apijabatan')->name('pegawainotadinas.apijabatan');
        Route::get('user/notadinas/apipegawai/','NotaDinasPegawaiController@apipegawai')->name('pegawainotadinas.apipegawai');

        Route::get('user/notadinas/data','NotaDinasPegawaiController@data')->name('pegawainotadinas.data');
        Route::resource('user/notadinas','NotaDinasPegawaiController',['as' => 'pegawai']);

    });


  });
