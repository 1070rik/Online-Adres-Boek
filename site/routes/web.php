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

Route::get('/home', 'HomeController@index')->name('home');
<<<<<<< HEAD
Route::get('/createUser', 'userController@createUser')->name('createUser');

Route::post('/addUser', 'userController@create')->name('addUserPost');
=======
>>>>>>> Added contact controller
Route::get('/addContact', 'contactsController@index')->name('addContactGet');
Route::post('/addContact', 'contactsController@addContact')->name('addContactPost');
