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

Route::get('/requestUser', 'userController@requestUser')->name('requestUser');
Route::post('requestUserPost', 'userController@requestUserPost')->name('requestUserPost');

Route::get('password/get_reset/{token}', 'userController@getPasswordReset')->name('getPasswordReset');
Route::post('requestPasswordPost', 'userController@requestPasswordPost')->name('requestPasswordPost');
Route::post('passwordResetPost}', 'userController@passwordResetPost')->name('passwordResetPost');

Route::post('/getAllContactsAjax', 'contactsController@getAllContactsAjax')->name('getAllContactsAjax');

Route::get('/search', 'SearchController@index')->name('searchGet');
Route::post('/bla', 'SearchController@postIndex')->name('searchPost');

Route::get('/contactImage/{filename}', [
    'uses' => 'contactsController@getImageFile',
    'as'   => 'contact.image',
]);

Route::middleware(['admin'])->group(function () {
    //Admin panel
    Route::get('/admin', 'adminController@index')->name('adminIndex');
    Route::get('/admin/contacts', 'adminController@getAllContacts')->name('adminGetAllContacts');
    Route::get('/admin/users', 'adminController@getAllUsers')->name('adminGetAllUsers');

    Route::get('getAllRequests', 'adminController@getAllRequests')->name('getAllRequests');
    Route::post('editRequestPost', 'userController@editRequestPost')->name('editRequestPost');

    //User actions
    Route::post('/editUser', 'userController@edit')->name('editUserPost');
    Route::get('/getAllUsers', 'userController@getAll')->name('getAllUsers');
    Route::post('/addUser', 'userController@create')->name('addUserPost');
    Route::get('/createUser', 'userController@createUser')->name('createUser');

    //Contact actions
    Route::get('/addContact', 'contactsController@index')->name('addContactGet');
    Route::post('/addContact', 'contactsController@addContact')->name('addContactPost');
    Route::get('/editContact', 'contactsController@editContact')->name('editContactGet');
    Route::post('/editContactPost', 'contactsController@editContactPost')->name('editContactPost');
    Route::post('/removeContacts', 'contactsController@removeContacts')->name('removeContacts');
    Route::get('/viewContact/{id}', 'contactsController@viewContact')->name('viewContactGet');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/loggedIn', 'userController@loggedIn');
    Route::get('/user/resetPassword', 'userController@resetPass')->name('resetPassword');
    Route::post('/user/resetPasswordFirst', 'userController@resetFirstPassPost')->name('resetFirstPasswordPost');

    Route::get('/', function () {
        return view('search.maps');
    })->name('index');
    Route::get('/getImage/{id}', 'contactsController@getImage')->name('getImage');
});
