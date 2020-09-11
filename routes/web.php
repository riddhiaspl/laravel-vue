<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

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


Route::middleware('auth')->group(function () {
    Route::get('/admin', 'AdminDashboardController@index')->name('dashboard');

    Route::get('/admin/user', 'AdminUserController@index')->name('user');
    Route::get('/admin/user/create', 'AdminUserController@create')->name('user.create');
    Route::post('/admin/user', 'AdminUserController@store')->name('user.add');
    Route::get('/admin/user/profile/{id}', 'AdminUserController@show')->name('user.show');
    Route::patch('/admin/user/update/{id}', 'AdminUserController@update')->name('user.update');
    Route::delete('/admin/user/delete/{id}', 'AdminUserController@destroy')->name('user.delete');

    Route::get('/admin/role', 'AdminRoleController@index')->name('role');
    Route::get('/admin/role/list', 'AdminRoleController@rolelist')->name('rolelist');
    Route::post('/admin/role', 'AdminRoleController@store')->name('role.add');
    Route::delete('/admin/role/delete/{id}', 'AdminRoleController@destroy')->name('role.destroy');
});
