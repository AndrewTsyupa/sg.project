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

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/post/{id}', 'HomeController@postView')->name('post-view');
Route::post('/save-post', 'HomeController@savePost')->name('save-post');
Route::get('/remove-post', 'HomeController@removePost')->name('remove-post');
Route::get('/delete-post/{id}', 'HomeController@deleteAndRedirectPost')->name('remove-post');

Route::post('/upload-post-images', 'HomeController@uploadPostImages')->name('upload-img');
Route::get('/remove-post-image', 'HomeController@removePostImage')->name('remove-img');

Route::post('/save-comment', 'HomeController@saveComment')->name('save-comment');
Route::get('/remove-comment', 'HomeController@removeComment')->name('remove-comment');

Route::get('/load-more-posts', 'HomeController@loadMorePosts')->name('load-more-posts');
Route::get('/load-more-comments', 'HomeController@loadMoreComments')->name('load-more-comments');

Route::get('/test-data', 'HomeController@testData')->name('testData');

Route::get('/admin/users', 'HomeController@usersForAdmin')->name('userForAdmin');
Route::get('/admin/edit-user/{id}', 'HomeController@editUser')->name('editUser');
Route::post('/admin/edit-user-save/{id}', 'HomeController@editUserSave')->name('editUser');

Route::get('/like-comment', 'HomeController@likeComment')->name('editUser');