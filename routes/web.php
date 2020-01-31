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

Route::get('/', 'HomeController@index')->name('welcome');

Route::post('/sbuscriber','SubscriberController@store')->name('sbuscriber.store');

Route::get('/search','SearchController@search')->name('search');

Route::get('/posts','PostDetailController@index')->name('post.index');
Route::get('/post/{slug}','PostDetailController@details')->name('post.details');
Route::get('/category/{slug}','PostDetailController@postByCategory')->name('category.posts');

Route::get('/tag/{slug}','PostDetailController@postByTag')->name('tag.posts');

Route::get('/profile/{username}','AuthorProfileController@profile')->name('author.profile');

Auth::routes();

Route::group(['middleware'=>['auth']], function(){

	//favourite
	Route::post('/favourite/{post}/add', 'FavouriteController@add')->name('post.favourite');

	//comment
	Route::post('/comment/{post}', 'CommentController@store')->name('comment.store');
});

Route::group(['as'=>'admin.', 'prefix'=>'admin', 'namespace'=>'Admin', 'middleware'=>['auth','admin']], function(){

	Route::get('/dashboard', ['as'=>'dashboard', 'uses'=>'AdminDashController@index']);

	//setting
	Route::get('/settings', 'SettingsController@index')->name('settings.index');
	//favourite
	Route::get('/favourite', 'AdminFavouriteContoller@index')->name('favourite.index');
	//profile
	Route::put('/profile-update', 'SettingsController@profileUpdate')->name('profile.update');
	//password
	Route::put('/password-update', 'SettingsController@passwordUpdate')->name('password.update');

	//main
	Route::resource('/tag', 'TagController');
	Route::resource('/category', 'CategoryController');
	Route::resource('/post', 'PostController');

	//Approval
	Route::get('/pending/post', 'PostController@pending')->name('post.pending');
	Route::put('/post/{id}/approve', 'PostController@approval')->name('post.approve');

	//Subscriber
	Route::get('/sbuscriber','AdminSubscriberController@index')->name('sbuscriber.index');
	Route::delete('/sbuscriber/{id}/delete','AdminSubscriberController@destroy')->name('sbuscriber.destroy');

	//Comment
	Route::get('/comments','AdminCommentController@index')->name('comment.index');
	Route::delete('/comments/{id}/delete','AdminCommentController@destroy')->name('comment.destroy');

	//Authors
	Route::get('/authors','AuthorShowController@index')->name('author.index');
	Route::delete('/authors/{id}/delete','AuthorShowController@destroy')->name('author.destroy');
});

Route::group(['as'=>'author.','prefix'=>'author','namespace'=>'Author','middleware'=>['auth','author']],function(){

	Route::get('/dashboard', ['as'=>'dashboard', 'uses'=>'AuthorDashController@index']);

	//setting
	Route::get('/settings', 'AuthorSettingsController@index')->name('settings.index');
	//favourite
	Route::get('/favourite', 'AuthorFavouriteContoller@index')->name('favourite.index');
	//profile
	Route::put('/profile-update', 'AuthorSettingsController@profileUpdate')->name('profile.update');
	//password
	Route::put('/password-update', 'AuthorSettingsController@passwordUpdate')->name('password.update');
	//Comment
	Route::get('/comments','AuthorCommentController@index')->name('comment.index');
	Route::delete('/comments/{id}/delete','AuthorCommentController@destroy')->name('comment.destroy');

	//main
	Route::resource('/post', 'AuthorPostController');
});

//globally
View::composer('layouts.frontend.partial.footer',function($view){
	$categories = App\Category::all();
	$view->with('categories',$categories);
});