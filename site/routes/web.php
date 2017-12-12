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

Route::post('/editUser', 'userController@edit')->name('editUserPost');

Route::get('/getAllUsers', 'userController@getAll')->name('getAllUsers');

Route::get('/createUser', 'userController@createUser')->name('createUser');
Route::post('/addUser', 'userController@create')->name('addUserPost');

Route::get('/addContact', 'contactsController@index')->name('addContactGet');
Route::post('/addContact', 'contactsController@addContact')->name('addContactPost');
Route::get('/editContact', 'contactsController@editContact')->name('editContactGet');
Route::post('/editContactPost', 'contactsController@editContactPost')->name('editContactPost');

Route::get('/search', 'SearchController@index')->name('searchGet');
Route::post('/bla', 'SearchController@postIndex')->name('searchPost');
