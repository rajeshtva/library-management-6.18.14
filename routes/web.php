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
// */

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// this was added by me just to remove not found classes. 😉 

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// users routes 
Route::get('/users/trashed', 'UserController@forceDeletePage')->middleware('isAdmin');
Route::post('/users/{user}/restore', 'UserController@restore')->middleware('isAdmin');
Route::delete('/users/{user}/force-delete','UserController@forceDelete')->middleware('isAdmin');
Route::resource('users', 'UserController');

Route::resource('roles', 'RoleController');

Route::resource('permissions', 'PermissionController');


// books route
Route::post('/books/unsubscribe', 'BookController@unsubscribe');
Route::get('/books/trashed', 'BookController@forceDeletePage')->middleware('isAdmin');
Route::post('/books/{book}/restore', 'BookController@restore')->middleware('isAdmin');
Route::post('/books/{book}/force-delete','BookController@forceDelete')->middleware('isAdmin');
Route::resource('books', 'BookController');


Route::get('/admin/dashboard', 'UserController@index')->middleware('isAdmin');

Route::post('/carts/store', 'CartController@store');
Route::get('/carts', 'CartController@index');
Route::delete('/carts/delete', 'CartController@destroy');
Route::post('/checkout', 'CartController@checkOut');
Route::get('/subscriptions', 'BookController@getSubscription');
Route::delete('/{user}/softdelete/{book}', 'CartController@softDeleteBookFromStore');