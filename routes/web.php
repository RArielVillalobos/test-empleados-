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
    return redirect('/home');
});

Auth::routes();

//rutas a las que solo puede acceder un usuario autenticado
Route::group(['middleware'=>['auth']],function (){
    Route::get('/home', 'HomeController@index')->name('home');

    Route::prefix('report')->group(function () {
        Route::get('/','ReportController@index')->name('report.index');
        Route::get('json','ReportController@reportesJson')->name('report.json');
        Route::post('store','ReportController@store')->name('report.store');
        Route::put('update','ReportController@update')->name('report.store');
        Route::post('destroy','ReportController@destroy')->name('report.destroy');

    });
//rutas que solo pueden ser accedidas por el administrador
    Route::group(['middleware' => ['role']], function () {
        //
        Route::prefix('user')->group(function () {
            Route::get('/','UserController@index')->name('user.index');
            Route::get('json','UserController@usersJson')->name('user.json');
            Route::get('selectRole','UserController@selectRole')->name('user.selectRole');
            Route::post('store','UserController@store')->name('user.store');
            Route::put('update','UserController@update')->name('user.update');
            Route::post('delete','UserController@delete')->name('user.delete');


        });
    });
});

