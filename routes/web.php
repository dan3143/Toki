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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/schedule', 'ScheduleController@index')->name('schedule')->middleware('auth');
Route::get('/deadlines', 'DeadlineController@index')->name('deadlines')->middleware('auth');
Route::post('/deadlines', 'DeadlineController@store')->name('deadlines.store')->middleware('auth');
Route::delete('/deadlines/{id}/delete', 'DeadlineController@delete')->name('deadlines.delete')->middleware('auth');
Route::get('/deadlines/create', 'DeadlineController@create')->name('deadlines.create')->middleware('auth');
Route::get('/deadlines/{id}/edit', 'DeadlineController@edit')->name('deadlines.edit')->middleware('auth');
Route::put('/deadlines/{id}/update', 'DeadlineController@update')->name('deadlines.update')->middleware('auth');
Route::get('/settings', 'SettingsController@index')->name('settings')->middleware('auth');