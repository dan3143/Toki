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
Route::get('/settings', 'SettingsController@index')->name('settings')->middleware('auth');
Route::get('/account', 'AccountController@index')->name('account')->middleware('auth');


//-----------Deadlines-------
Route::get('/deadlines', 'DeadlineController@index')->name('deadlines')->middleware('auth');
Route::get('/deadlines/create', 'DeadlineController@create')->name('deadlines.create')->middleware('auth');
Route::post('/deadlines', 'DeadlineController@store')->name('deadlines.store')->middleware('auth');
Route::delete('/deadlines/{id}/delete', 'DeadlineController@delete')->name('deadlines.delete')->middleware('auth');
Route::get('/deadlines/{id}/edit', 'DeadlineController@edit')->name('deadlines.edit')->middleware('auth');
Route::put('/deadlines/{id}/update', 'DeadlineController@update')->name('deadlines.update')->middleware('auth');

//----------Subjects--------
Route::get('/subjects', 'SubjectController@index')->name('subjects')->middleware('auth');
Route::get('/subjects/create_subject', 'SubjectController@create')->name('subjects.create')->middleware('auth');
Route::get('/subjects/{id}', 'SubjectController@show')->name('subjects.show')->middleware('auth');
Route::post('/subjects', 'SubjectController@store')->name('subjects.store')->middleware('auth');
Route::post('/subjects/{id}/add_grade', 'SubjectController@addGrade')->name('subjects.add_grade')->middleware('auth');
Route::get('/subjects/{id}/get_sum', 'SubjectController@getSum')->name('subjects.get_sum')->middleware('auth');
Route::delete('/subjects/{id}/grade/{grade_id}/delete', 'SubjectController@delete_grade')->name('subjects.delete_grade')->middleware('auth');
Route::delete('/subjects/{id}/delete', 'SubjectController@delete')->name('subjects.delete')->middleware('auth');
Route::get('/subjects/{id}/edit', 'SubjectController@edit')->name('subjects.edit')->middleware('auth');
Route::put('/subjects/{id}/update', 'SubjectController@update')->name('subjects.update')->middleware('auth');
Route::put('/subjects/{id}/increment', 'SubjectController@increment')->name('subjects.increment')->middleware('auth');
Route::put('/subjects/{id}/decrement', 'SubjectController@decrement')->name('subjects.decrement')->middleware('auth');

