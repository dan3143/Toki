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
})->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/schedule', 'ScheduleController@index')->name('schedule')->middleware('auth');

//------- User --------
Route::get('/profile', 'ProfileController@index')->name('profile')->middleware('auth');
Route::post('/profile', 'ProfileController@update')->name('profile.update')->middleware('auth');
Route::delete('/profile', 'ProfileController@delete')->name('profile.delete')->middleware('password.confirm');
Route::get('/profile/change_password', 'ProfileController@change_password')->name('profile.change_password')->middleware('auth');
Route::put('/profile/change_password', 'ProfileController@update_password')->name('profile.update_password')->middleware('auth');

//------- Posts ------
Route::get('/posts/create', 'PostController@create')->name('posts.create')->middleware('auth', 'role:blogger');
Route::get('/posts/{id}', 'PostController@show')->name('posts.show')->middleware('auth');
Route::post('/posts', 'PostController@store')->name('posts.store')->middleware('auth', 'role:blogger');
Route::get('/posts/{id}/edit', 'PostController@edit')->name('posts.edit')->middleware('auth', 'role:blogger');
Route::put('/posts/{id}/edit', 'PostController@update')->name('posts.update')->middleware('auth', 'role:blogger');
Route::delete('/posts/{id}/delete', 'PostController@delete')->name('posts.delete')->middleware('auth', 'role:blogger');

//-------User Rooms--------
Route::get('/user_room', 'UserRoomController@index')->name('user_room')->middleware('auth');
Route::post('/user_room', 'UserRoomController@store')->name('user_room.store')->middleware('auth', 'admin');
Route::delete('/user_room/{id}', 'UserRoomController@delete')->name('user_room.delete')->middleware('auth', 'role:admin');
Route::put('/user_room/update', 'UserRoomController@update')->name('user_room.update')->middleware('auth', 'role:admin');
Route::put('/user_room/{id}/change_status', 'UserRoomController@change_status')->name('user_room.change_status')->middleware('auth', 'role:admin');
Route::get('/user_room_management/{id}', 'UserRoomManagementController@index')->name('user_room_management')->middleware('auth', 'role:admin');
Route::post('/user_room_management/{id}', 'UserRoomManagementController@addComputer')->name('user_room_management.add_computer')->middleware('auth', 'role:admin');
Route::delete('/user_room_management/delete/{pc_id}', 'UserRoomManagementController@deleteComputer')->name('user_room_management.delete_computer')->middleware('auth', 'role:admin');
Route::put('/user_room_management/{pc_id}/change_status', 'UserRoomManagementController@change_status')->middleware('auth', 'role:admin');


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

//--------Routine------
Route::get('/routine/{day}', 'RoutineController@index')->name('routine')->middleware('auth');
Route::post('/routine/{day}', 'RoutineController@store')->name('routine.store')->middleware('auth');
Route::put('/routine/{day}', 'RoutineController@update')->name('routine.update')->middleware('auth');
Route::delete('/routine/{id}/delete', 'RoutineController@delete')->name('routine.delete')->middleware('auth');
