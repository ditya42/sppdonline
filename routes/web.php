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

    //master/SuratKeluar
    Route::get('adminskpd/suratkeluar/data','SuratKeluarAdminSKPDController@data')->name('adminskpdsuratkeluar.data');
    Route::resource('adminskpd/suratkeluar','SuratKeluarAdminSKPDController', ['as' => 'adminskpdsuratkeluar']);
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

        //master/jenissurat
      Route::get('user/jenissurat/data','JenisSuratPegawaiController@data')->name('pegawaijenissurat.data');
      Route::resource('user/jenissurat','JenisSuratPegawaiController', ['as' => 'pegawai']);

      //master//DasarSurat
      Route::get('user/dasarsurat/data','DasarPegawaiController@data')->name('pegawaidasarsurat.data');
      Route::resource('user/dasarsurat','DasarPegawaiController', ['as' => 'pegawai']);

      //master/SuratKeluar
      Route::get('user/suratkeluar/data','SuratKeluarPegawaiController@data')->name('pegawaisuratkeluar.data');
      Route::get('user/suratkeluar','SuratKeluarPegawaiController@index')->name('pegawaisuratkeluar.index');
    });

    Route::namespace('Pegawai')->group(function () {

        //pegawai berangkat
        Route::get('user/notadinas/pegawaiberangkat/data','PegawaiBerangkatController@data')->name('pegawaiberangkat.data');
        Route::get('user/notadinas/pegawaiberangkat/{id}','PegawaiBerangkatController@index')->name('pegawaiberangkat');
        Route::post('user/notadinas/pegawaiberangkat','PegawaiBerangkatController@store')->name('pegawaiberangkat.store');
        Route::delete('user/notadinas/pegawaiberangkat/{id}','PegawaiBerangkatController@destroy')->name('pegawaiberangkat.destroy');

        //Dasar Surat
        Route::get('user/notadinas/dasarsurat/data','DasarNotaDinasController@data')->name('dasarnotadinas.data');
        Route::get('user/notadinas/dasarsurat/{id}','DasarNotaDinasController@index')->name('dasarnotadinas.index');
        Route::get('user/notadinas/apidasar/','DasarNotaDinasController@apidasar')->name('dasarnotadinas.apidasar');
        Route::post('user/notadinas/dasarsurat','DasarNotaDinasController@store')->name('dasarnotadinas.store');
        Route::post('user/notadinas/dasarsuratbaru','DasarNotaDinasController@storebaru')->name('dasarnotadinas.storebaru');
        Route::delete('user/notadinas/dasarsurat/{id}','DasarNotaDinasController@destroy')->name('dasarnotadinas.destroy');

        Route::get('user/notadinas/apijabatan/','NotaDinasPegawaiController@apijabatan')->name('pegawainotadinas.apijabatan');
        Route::get('user/notadinas/apipegawai/','NotaDinasPegawaiController@apipegawai')->name('pegawainotadinas.apipegawai');


        Route::get('user/notadinas/data','NotaDinasPegawaiController@data')->name('pegawainotadinas.data');
        Route::resource('user/notadinas','NotaDinasPegawaiController',['as' => 'pegawai']);

        //setujui
        Route::get('user/notadinas/setujui/{id}','NotaDinasPegawaiController@setujui')->name('pegawainotadinas.setujui');

    });


  });
