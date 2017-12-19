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
})->name('index');
Auth::routes();



Route::post('/getAllContactsAjax', 'contactsController@getAllContactsAjax')->name('getAllContactsAjax');

Route::get('/search', 'SearchController@index')->name('searchGet');
Route::post('/bla', 'SearchController@postIndex')->name('searchPost');


Route::middleware(['admin'])->group(function () {
  Route::get('/admin', 'adminController@index')->name('adminIndex');
  Route::get('/admin/contacts', 'adminController@getAllContacts')->name('adminGetAllContacts');
  Route::get('/admin/users', 'adminController@getAllUsers')->name('adminGetAllUsers');

  Route::post('/editUser', 'userController@edit')->name('editUserPost');
  Route::get('/getAllUsers', 'userController@getAll')->name('getAllUsers');
  Route::post('/addUser', 'userController@create')->name('addUserPost');
  Route::get('/addContact', 'contactsController@index')->name('addContactGet');
  Route::post('/addContact', 'contactsController@addContact')->name('addContactPost');
  Route::get('/editContact', 'contactsController@editContact')->name('editContactGet');
  Route::post('/editContactPost', 'contactsController@editContactPost')->name('editContactPost');
  Route::get('/viewContact/{id}', 'contactsController@viewContact')->name('viewContactGet');
  Route::get('/createUser', 'userController@createUser')->name('createUser');
});

Route::middleware(['auth'])->group(function () {
  Route::get('/home', 'HomeController@index')->name('home');
  Route::get('/loggedIn', 'userController@loggedIn');
  Route::get('/user/resetPassword', 'userController@resetPass')->name('resetPassword');
  Route::post('/user/resetPasswordFirst', 'userController@resetFirstPassPost')->name('resetFirstPasswordPost');
});
