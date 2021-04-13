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

    //Surat Keluar untuk superadmin
    Route::get('superadmin/suratkeluar/data','SuratKeluarSuperAdminController@data')->name('superadminsuratkeluar.data');
    Route::get('superadmin/suratkeluar/datatrash','SuratKeluarSuperAdminController@datatrash')->name('superadminsuratkeluar.datatrash');
    Route::post('superadmin/suratkeluar/restore/{id}','SuratKeluarSuperAdminController@restore')->name('superadminsuratkeluar.restore');
    Route::delete('superadmin/suratkeluar/deletepermanen/{id}','SuratKeluarSuperAdminController@deletepermanen')->name('superadminsuratkeluar.deletepermanen');
    Route::get('superadmin/suratkeluar/trash','SuratKeluarSuperAdminController@trash')->name('superadminsuratkeluar.trash');
    Route::resource('superadmin/suratkeluar','SuratKeluarSuperAdminController', ['as' => 'superadminsuratkeluar']);

    //pegawai berangkat untuk notadinas superadmin
    Route::get('superadmin/notadinas/pegawaiberangkat/data','PegawaiBerangkatSuperAdminController@data')->name('superadminpegawaiberangkat.data');
    Route::get('superadmin/notadinas/pegawaiberangkat/{id}','PegawaiBerangkatSuperAdminController@index')->name('superadminpegawaiberangkat.index');
    Route::post('superadmin/notadinas/pegawaiberangkat','PegawaiBerangkatSuperAdminController@store')->name('superadminpegawaiberangkat.store');
    Route::delete('superadmin/notadinas/pegawaiberangkat/{id}','PegawaiBerangkatSuperAdminController@destroy')->name('superadminpegawaiberangkat.destroy');

    //Dasar Surat untuk notadinas superadmin
    Route::get('superadmin/notadinas/dasarsurat/data','DasarNotaDinasSuperAdminController@data')->name('superadmindasarnotadinas.data');
    Route::get('superadmin/notadinas/dasarsurat/{id}','DasarNotaDinasSuperAdminController@index')->name('superadmindasarnotadinas.index');
    Route::get('superadmin/notadinas/apidasar/','DasarNotaDinasSuperAdminController@apidasar')->name('superadmindasarnotadinas.apidasar');
    Route::post('superadmin/notadinas/dasarsurat','DasarNotaDinasSuperAdminController@store')->name('superadmindasarnotadinas.store');
    Route::post('superadmin/notadinas/dasarsuratbaru','DasarNotaDinasSuperAdminController@storebaru')->name('superadmindasarnotadinas.storebaru');
    Route::delete('superadmin/notadinas/dasarsurat/{id}','DasarNotaDinasSuperAdminController@destroy')->name('superadmindasarnotadinas.destroy');


    //Nota Dinas untuk superadmin
    Route::get('superadmin/notadinas/data','NotaDinasSuperAdminController@data')->name('superadminnotadinas.data');

    Route::get('superadmin/notadinas/apijabatan/','NotaDinasSuperAdminController@apijabatan')->name('superadminnotadinas.apijabatan');
    Route::get('superadmin/notadinas/apipegawai/','NotaDinasSuperAdminController@apipegawai')->name('superadminnotadinas.apipegawai');
    Route::get('superadmin/notadinas/apiskpd/','NotaDinasSuperAdminController@apiskpd')->name('superadminnotadinas.apiskpd');
    Route::get('superadmin/notadinas/{notadina}/edit2','NotaDinasSuperAdminController@edit2')->name('superadminnotadinas.notadinas.edit2');
    Route::patch('superadmin/notadinasmasteredit/{id}','NotaDinasSuperAdminController@update2')->name('notadinas.masteredit');
    Route::resource('superadmin/notadinas','NotaDinasSuperAdminController', ['as' => 'superadmin']);

    Route::get('superadmin/notadinas/setujui/{id}','NotaDinasSuperAdminController@setujui')->name('superadminnotadinas.setujui');




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
    Route::get('adminskpd/suratkeluar/datatrash','SuratKeluarAdminSKPDController@datatrash')->name('adminskpdsuratkeluar.datatrash');
    Route::post('adminskpd/suratkeluar/restore/{id}','SuratKeluarAdminSKPDController@restore')->name('adminskpdsuratkeluar.restore');
    Route::delete('adminskpd/suratkeluar/deletepermanen/{id}','SuratKeluarAdminSKPDController@deletepermanen')->name('adminskpdsuratkeluar.deletepermanen');
    Route::get('adminskpd/suratkeluar/trash','SuratKeluarAdminSKPDController@trash')->name('adminskpdsuratkeluar.trash');
    Route::resource('adminskpd/suratkeluar','SuratKeluarAdminSKPDController', ['as' => 'adminskpdsuratkeluar']);

    //master adminskpd notadinas
    Route::get('adminskpd/masternotadinas/data','NotaDinasMasterAdminSKPDController@data')->name('adminskpdmasternotadinas.data');

    Route::get('adminskpd/masternotadinas/pegawaiberangkat/data','PegawaiBerangkatMasterAdminSKPDController@data')->name('pegawaiberangkatadminskpdmaster.data');
    Route::get('adminskpd/masternotadinas/pegawaiberangkat/{id}','PegawaiBerangkatMasterAdminSKPDController@index')->name('pegawaiberangkatadminskpdmaster');

    Route::get('adminskpd/masternotadinas/dasarsurat/data','DasarNotaMasterAdminSKPDController@data')->name('dasarnotaadminskpdmaster.data');
    Route::get('adminskpd/masternotadinas/dasarsurat/{id}','DasarNotaMasterAdminSKPDController@index')->name('dasarnotaadminskpdmaster');

    Route::get('adminskpd/masternotadinas/apiskpd/','NotaDinasMasterAdminSKPDController@apiskpd')->name('adminskpdmasternotadinas.apiskpd');
    Route::resource('adminskpd/masternotadinas','NotaDinasMasterAdminSKPDController', ['as' => 'adminskpdmaster']);


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


    //pegawai berangkat
    Route::get('adminskpd/notadinas/pegawaiberangkat/data','PegawaiBerangkatAdminSKPDController@data')->name('pegawaiberangkatadminskpd.data');
    Route::get('adminskpd/notadinas/pegawaiberangkat/{id}','PegawaiBerangkatAdminSKPDController@index')->name('pegawaiberangkatadminskpd');
    Route::post('adminskpd/notadinas/pegawaiberangkat','PegawaiBerangkatAdminSKPDController@store')->name('pegawaiberangkatadminskpd.store');
    Route::delete('adminskpd/notadinas/pegawaiberangkat/{id}','PegawaiBerangkatAdminSKPDController@destroy')->name('pegawaiberangkatadminskpd.destroy');

    //Dasar Surat
    Route::get('adminskpd/notadinas/dasarsurat/data','DasarNotaDinasAdminSKPDController@data')->name('dasarnotadinasadminskpd.data');
    Route::get('adminskpd/notadinas/dasarsurat/{id}','DasarNotaDinasAdminSKPDController@index')->name('dasarnotadinasadminskpd.index');
    Route::get('adminskpd/notadinas/apidasar/','DasarNotaDinasAdminSKPDController@apidasar')->name('dasarnotadinasadminskpd.apidasar');
    Route::post('adminskpd/notadinas/dasarsurat','DasarNotaDinasAdminSKPDController@store')->name('dasarnotadinasadminskpd.store');
    Route::post('adminskpd/notadinas/dasarsuratbaru','DasarNotaDinasAdminSKPDController@storebaru')->name('dasarnotadinasadminskpd.storebaru');
    Route::delete('adminskpd/notadinas/dasarsurat/{id}','DasarNotaDinasAdminSKPDController@destroy')->name('dasarnotadinasadminskpd.destroy');


    //api jabatan dan pegawai
    Route::get('adminskpd/notadinas/apijabatan/','NotaDinasAdminSKPDController@apijabatan')->name('adminskpdnotadinas.apijabatan');
    Route::get('adminskpd/notadinas/apipegawai/','NotaDinasAdminSKPDController@apipegawai')->name('adminskpdnotadinas.apipegawai');

    //pengajuan nota dinas sebagai admin skpd
    Route::get('adminskpd/notadinas/data','NotaDinasAdminSKPDController@data')->name('adminskpdnotadinas.data');
    Route::resource('adminskpd/notadinas','NotaDinasAdminSKPDController',['as' => 'adminskpdnotadinas']);

    //setujui
     Route::get('adminskpd/notadinas/setujui/{id}','NotaDinasAdminSKPDController@setujui')->name('adminskpdnotadinas.setujui');
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

        //notadinas
        Route::get('user/notadinas/apijabatan/','NotaDinasPegawaiController@apijabatan')->name('pegawainotadinas.apijabatan');
        Route::get('user/notadinas/apipegawai/','NotaDinasPegawaiController@apipegawai')->name('pegawainotadinas.apipegawai');


        Route::get('user/notadinas/data','NotaDinasPegawaiController@data')->name('pegawainotadinas.data');
        Route::resource('user/notadinas','NotaDinasPegawaiController',['as' => 'pegawai']);

        //setujui
        Route::get('user/notadinas/setujui/{id}','NotaDinasPegawaiController@setujui')->name('pegawainotadinas.setujui');

        //pengajuan surat keluar pegawai
        Route::get('user/pengajuansuratkeluar/data','PengajuanSuratKeluarController@data')->name('pengajuansuratkeluar.data');
        Route::get('user/pengajuansuratkeluar','PengajuanSuratKeluarController@index')->name('pengajuansuratkeluar.index');

    });


  });
