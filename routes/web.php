<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [HomeController::class,'home'])->name('home');
// Route::get('/', 'HomeController@home') ->name('home')
    // ->middleware('auth')
    ;
Route::get('/contact', 'HomeController@contact')->name('contact');
Route::get('/secret', 'HomeController@secret')->name('secret')->middleware('can:home.secret');

// Route::get('/blog-post/{id}/{welcome?}', 'HomeController@blogPost')->name('blog-post');
Route::resource('posts', 'PostController');
Route::get('/posts/tag/{tag}', 'PostTagController@index')->name('posts.tags.index');

Route::resource('/posts.comments', 'PostCommentController')->only(['store']);
Route::resource('users', 'UserController')->only(['show','edit','update']);


Auth::routes();
