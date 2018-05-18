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

// US.1
Route::get('/', 'UserController@index')->name('users.index');

// Listagem US.5/6
Route::get('users', 'AdminController@index')->name('admins.index');

// Atualizacao dos users US.7
Route::patch('users/{user}/block', 'AdminController@block')->name('admins.block');
Route::patch('users/{user}/unblock', 'AdminController@unblock')->name('admins.unblock');
Route::patch('users/{user}/promote', 'AdminController@promote')->name('admins.promote');
Route::patch('users/{user}/demote', 'AdminController@demote')->name('admins.demote');

// Formulário para pass
Route::get('me/password', 'UserController@renderPassword')->name('users.renderPassword');
// Atualizaçao da pass US.9
Route::patch('me/password', 'UserController@password')->name('users.password')->middleware('auth');

// Formulário para perfil
Route::get('me/profile', 'ProfileController@renderProfile')->name('profile.render');
// Atualizaçao do perfil US.10
Route::put('me/profile', 'ProfileController@updateProfile')->name('profile.update');

//Profiles US.11
Route::get('profiles', 'ProfileController@profiles')->name('profiles');

//Associados US.12
Route::get('me/associates', 'ProfileController@associates')->name('profile.associates');
//Associados US.13
Route::get('me/associate-of', 'ProfileController@associatesOf')->name('profile.associatesOf');

//Accounts US.14
Route::get('accounts/{user}', 'AccountController@accountsIndex')->name('accounts');
Route::get('accounts/{user}/opened', 'AccountController@opened')->name('account.opened');
Route::get('accounts/{user}/closed', 'AccountController@closed')->name('account.closed');

//Accounts US.15
Route::delete('accounts/{account}', 'AccountController@destroyAcc')->name('account.destroy');
Route::patch('accounts/{account}/close', 'AccountController@closeAcc')->name('account.close');

//Accounts US.16
Route::patch('account/{account}/open', 'AccountController@openAcc')->name('account.open');

//Submissao account US.17
Route::post('account', 'AccountController@accountSave')->name('account.save');

//Accounts US.18
Route::put('account/{account}', 'AccountController@editAccount')->name('account.edit');

//Movements US.20
Route::get('movements/{account}', 'MovementController@movementsIndex')->name('movements');

//Movements US.21
Route::get('movements/{account}/create', 'MovementController@create')->name('movements.create');
Route::post('movements/{account}/create', 'MovementController@store')->name('movements.store');
Route::get('movements/{account}/{movement}', 'MovementController@edit')->name('movements.edit');
Route::put('movements/{account}/{movement}', 'MovementController@update')->name('movements.update');
Route::delete('movements/{account}/{movement}', 'MovementController@destroy')->name('movements.destroy');

//Store document US.23
Route::post('documents/{movement}', 'DocumentController@store')->name('documents.store');

//Destroy document US.24
Route::delete('/documents/{movement}/{document}', 'DocumentController@destroy')->name('documents.destroy');

//Documents index US.25
Route::get('documents/{movement}', 'DocumentController@index')->name('documents');

//Dashboard US.26
Route::get('me/dashboard', 'UserController@dashboard')->name('users.dashboard');

//storeAssociate US.29
Route::post('me/associates', 'UserController@storeAssociate')->name('users.storeAssociate');

//destroyAssociate US.30
Route::delete('me/associates/{user}', 'UserController@destroyAssociate')->name('users.destroyAssociate');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

