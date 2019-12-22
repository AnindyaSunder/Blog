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
    return view('welcome'); } )->name('welcome');

Route::post('/sbuscriber','SubscriberController@store')->name('sbuscriber.store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['as'=>'admin.', 'prefix'=>'admin', 'namespace'=>'Admin', 'middleware'=>['auth','admin']], function(){

	Route::get('/dashboard', ['as'=>'dashboard', 'uses'=>'AdminDashController@index']);
	Route::resource('/tag', 'TagController');
	Route::resource('/category', 'CategoryController');
	Route::resource('/post', 'PostController');

	//Approval
	Route::get('/pending/post', 'PostController@pending')->name('post.pending');
	Route::put('/post/{id}/approve', 'PostController@approval')->name('post.approve');

	//Subscriber
	Route::get('/sbuscriber','AdminSubscriberController@index')->name('sbuscriber.index');
	Route::delete('/sbuscriber/{id}/delete','AdminSubscriberController@destroy')->name('sbuscriber.destroy');
	
});

Route::group(['as'=>'author.','prefix'=>'author','namespace'=>'Author','middleware'=>['auth','author']],function(){

	Route::get('/dashboard', ['as'=>'dashboard', 'uses'=>'AuthorDashController@index']);
	Route::resource('/post', 'AuthorPostController');
});