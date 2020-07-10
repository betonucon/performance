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


Route::get('a/{personnel_no}/', 'Auth\LoginController@programaticallyEmployeeLogin')->name('login.a');

Route::group(['middleware'    => 'auth'],function(){
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('rolee/', 'UnitController@rolee');

    Route::group(['prefix' => 'unit'], function(){
        Route::get('/', 'UnitController@index');
        Route::get('/index_tingkatan', 'UnitController@index_tingkatan');
        Route::get('/edit/{id}', 'UnitController@edit');
        Route::get('/edit_tingkatan/{id}', 'UnitController@edit_tingkatan');
        Route::post('/simpan/{id}', 'UnitController@simpan');
        Route::post('/simpan_tingkatan/{id}', 'UnitController@simpan_tingkatan');
        Route::get('/cek_nik/{act}/{id}', 'UnitController@cek_nik');
        Route::post('/import_data_unit', 'UnitController@import_data');
        
    });

    Route::group(['prefix' => 'pengaturan'], function(){
        Route::get('/', 'PengaturanController@index');
        Route::post('/simpan_tanggal_validasi', 'PengaturanController@simpan_tanggal_validasi');
        Route::post('/edit_simpan_tanggal_validasi/{id}', 'PengaturanController@edit_simpan_tanggal_validasi');
        
    });

    Route::group(['prefix' => 'deployment'], function(){
        Route::get('/', 'DeploymentController@index');
        Route::get('/mandatori', 'DeploymentController@index_mandatori');
        Route::get('/non', 'DeploymentController@index_non');
        Route::get('/edit/{id}', 'DeploymentController@edit');
        Route::get('/edit_mandatori/{id}', 'DeploymentController@edit_mandatori');
        Route::post('/simpan/{id}', 'DeploymentController@simpan');
        Route::post('/import_data/', 'DeploymentController@import_data');
        Route::post('/import_data_mandatori/', 'DeploymentController@import_data_mandatori');
    });

    Route::group(['prefix' => 'target'], function(){
        Route::get('/', 'TargetController@index');
        Route::get('/mandatori', 'TargetController@index_mandatori');
        Route::get('/non', 'TargetController@index_non');
        Route::get('/input/{id}', 'TargetController@input_target');
        Route::get('/input-mandatori/{id}', 'TargetController@input_target_mandatori');
        Route::get('/validasi_atasan_target/{id}', 'TargetController@validasi_atasan_target');
        Route::get('/validasi_atasan_realisasi/{id}', 'TargetController@validasi_atasan_realisasi');
        Route::get('/validasi_admin_target/{id}', 'TargetController@validasi_admin_target');
        Route::get('/unvalidasi_admin_target/{id}', 'TargetController@unvalidasi_admin_target');
        Route::get('/validasi_admin_realisasi/{id}', 'TargetController@validasi_admin_realisasi');
        Route::get('/validasi_all/{id}', 'TargetController@validasi_all');
        Route::post('/simpan/{id}', 'TargetController@simpan');
        Route::post('/simpan_target/{id}', 'TargetController@simpan_target');
        Route::post('/simpan_selesai_target/{id}', 'TargetController@simpan_selesai_target');
        Route::post('/import_data/', 'TargetController@import_data');
    });

    Route::group(['prefix' => 'pdf'], function(){
        Route::get('/capaian', 'RealisasiController@pdf');
        Route::get('/capaian-mandatori', 'RealisasiController@pdf_mandatori');
    });

    Route::group(['prefix' => 'excel'], function(){
        Route::get('/capaian', 'RealisasiController@excel');
        Route::get('/capaian-mandatori', 'RealisasiController@excel_mandatori');
    });

    Route::group(['prefix' => 'laporan'], function(){
        Route::get('/', 'RealisasiController@laporan');
        Route::get('/bertingkat/{id}', 'RealisasiController@laporan_tingkatan');
        Route::get('/mandatori', 'RealisasiController@laporan_mandatori');
    });
    Route::group(['prefix' => 'realisasi'], function(){
        Route::get('/', 'RealisasiController@index');
        Route::get('/mandatori', 'RealisasiController@index_mandatori');
        Route::get('/non', 'RealisasiController@index_non');
        Route::get('/input/{id}', 'RealisasiController@input_realisasi');
        Route::get('/input-mandatori/{id}', 'RealisasiController@input_realisasi_mandatori');
        Route::get('/validasi_atasan_realisasi/{id}', 'RealisasiController@validasi_atasan_realisasi');
        Route::get('/validasi_atasan_realisasi/{id}', 'RealisasiController@validasi_atasan_realisasi');
        Route::get('/validasi_admin_realisasi/{id}', 'RealisasiController@validasi_admin_realisasi');
        Route::get('/validasi_admin_realisasi/{id}', 'RealisasiController@validasi_admin_realisasi');
        Route::post('/simpan/{id}', 'RealisasiController@simpan');
        Route::post('/simpan_realisasi/{id}', 'RealisasiController@simpan_realisasi');
        Route::get('/perhitungan/', 'RealisasiController@perhitungan');
    });

    Route::group(['prefix' => 'kpi'], function(){
        Route::get('/', 'KpiController@index');
        Route::get('/edit/{id}', 'KpiController@edit');
        Route::post('/simpan/{id}', 'KpiController@simpan');
        Route::post('/import_data/', 'KpiController@import_data');
    });

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/pdf', 'HomeController@pdf')->name('pdf');
