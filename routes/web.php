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

Route::get('/', 'Auth\LoginController@loginform')->name('users.loginform');
Route::post('loginuser', 'Auth\LoginController@login')->name('users.login');
Route::get('logout', 'Auth\LoginController@logout')->name('users.logout');

// Dashboard
Route::get('dashboard', 'DashboardController@index')->name('dashboard.dashboard');

//Accounts
Route::get('accounts', 'AccountsController@index')->name('accounts.index');
Route::get('accounts/new', 'AccountsController@new')->name('accounts.new');
Route::get('accounts/edit/{id}', 'AccountsController@edit')->name('account.edit');
Route::post('accounts/store/{id}', 'AccountsController@store')->name('account.save');
Route::get('accounts/reset/{id}', 'AccountsController@reset')->name('account.reset');

//Regions
Route::get('regions', 'RegionsController@index')->name('region.index');
Route::get('region/new', 'RegionsController@new')->name('region.new');
Route::post('region/store/{id}', 'RegionsController@store')->name('region.save');
Route::get('region/edit/{id}', 'RegionsController@edit')->name('region.edit');
Route::get('region/delete/{id}', 'RegionsController@delete')->name('region.delete');