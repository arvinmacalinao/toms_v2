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
Route::any('accounts', 'AccountsController@index')->name('accounts.index');
Route::get('accounts/new', 'AccountsController@new')->name('accounts.new');
Route::get('accounts/edit/{id}', 'AccountsController@edit')->name('account.edit');
Route::post('accounts/store/{id}', 'AccountsController@store')->name('account.save');
Route::get('accounts/reset/{id}', 'AccountsController@reset')->name('account.reset');
Route::get('accounts/delete/{id}', 'AccountsController@delete')->name('account.delete');

//Regions
Route::any('regions', 'RegionsController@index')->name('region.index');
Route::get('region/new', 'RegionsController@new')->name('region.new');
Route::post('region/store/{id}', 'RegionsController@store')->name('region.save');
Route::get('region/edit/{id}', 'RegionsController@edit')->name('region.edit');
Route::get('region/delete/{id}', 'RegionsController@delete')->name('region.delete');

//Roles
Route::any('roles', 'RolesController@index')->name('roles.index');
Route::get('role/new', 'RolesController@new')->name('role.new');
Route::post('role/store/{id}', 'RolesController@store')->name('role.save');
Route::get('role/edit/{id}', 'RolesController@edit')->name('role.edit');
Route::get('role/delete/{id}', 'RolesController@delete')->name('role.delete');

//Funds
Route::any('funds', 'FundsController@index')->name('funds.index');
Route::get('fund/new', 'FundsController@new')->name('fund.new');
Route::post('fund/store/{id}', 'FundsController@store')->name('fund.save');
Route::get('fund/edit/{id}', 'FundsController@edit')->name('fund.edit');
Route::get('fund/delete/{id}', 'FundsController@delete')->name('fund.delete');

//Expenses
Route::any('expenses', 'ExpensesController@index')->name('expenses.index');
Route::get('expense/new', 'ExpensesController@new')->name('expense.new');
Route::post('expense/store/{id}', 'ExpensesController@store')->name('expense.save');
Route::get('expense/edit/{id}', 'ExpensesController@edit')->name('expense.edit');
Route::get('expense/delete/{id}', 'ExpensesController@delete')->name('expense.delete');

//Modes
Route::any('vehicle-modes', 'VehicleModesController@index')->name('modes.index');
Route::get('vehicle-mode/new', 'VehicleModesController@new')->name('mode.new');
Route::post('vehicle-mode/store/{id}', 'VehicleModesController@store')->name('mode.save');
Route::get('vehicle-mode/edit/{id}', 'VehicleModesController@edit')->name('mode.edit');
Route::get('vehicle-mode/delete/{id}', 'VehicleModesController@delete')->name('mode.delete');

//Settings
Route::any('settings', 'SettingsController@index')->name('settings.index');
Route::get('setting/new', 'SettingsController@new')->name('setting.new');
Route::post('setting/store/{id}', 'SettingsController@store')->name('setting.save');
Route::get('setting/edit/{id}', 'SettingsController@edit')->name('setting.edit');
Route::get('setting/delete/{id}', 'SettingsController@delete')->name('setting.delete');

//Travel Order
Route::any('travels', 'TravelController@index')->name('travels.index');