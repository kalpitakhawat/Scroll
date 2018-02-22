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
Auth::routes();
Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});
Route::get('/register', 'RootController@showRegistrationForm')->middleware('guest')->name('register');
Route::get('/login', 'RootController@showLoginForm')->middleware('guest')->name('login');
Route::get('/post/{id}' , 'PostController@details')->name('postDetails');
Route::get('/profile' , 'RootController@profilepic')->name('profilePicUpload');
Route::post('/api/post','PostController@create');
Route::post('/api/upload','PostController@upload');
Route::post('/api/avatarupload','RootController@avatarupload');
Route::post('/api/getPost','PostController@index');
Route::post('/api/like','PostController@like');
Route::post('/api/unlike','PostController@unlike');
Route::post('/api/getDetails','PostController@getDetails');
Route::post('/api/addComment','CommentController@create');
