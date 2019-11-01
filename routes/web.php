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
Route::get('/deadlines/create', 'CreateDeadlineController@index')->name('deadlines.create')->middleware('auth');
Route::post('/deadlines/create', 'CreateDeadlineController@store')->name('deadlines.store')->middleware('auth');
Route::get('/settings', 'SettingsController@index')->name('settings')->middleware('auth');