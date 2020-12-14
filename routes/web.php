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


Route::get('/', 'HomeController@home')
    ->name('home')
    // ->middleware('auth')
    ;
Route::get('/contact', 'HomeController@contact')->name('contact');
// Route::get('/blog-post/{id}/{welcome?}', 'HomeController@blogPost')->name('blog-post');
Route::resource('/posts', 'PostController');

Auth::routes();