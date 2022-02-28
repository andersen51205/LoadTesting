<?php

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

/**
 * 前台
 */

// 前台首頁
Route::get('/', 'Guest\GuestController@main')->name('Guest_View');

/**
 * 後台
 */

Auth::routes();
/*
// 驗證相關
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// 註冊相關
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
// 重設密碼相關
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
*/
// 驗證相關
Route::get('login', 'Auth\LoginController@main')->name('Login_View');
Route::post('login', 'Auth\LoginController@login')->name('Login');
Route::post('logout', 'Auth\LoginController@logout')->name('Logout');


/**
 * 使用者
 */

// 使用者首頁
Route::get('/backend/user', 'User\UserController@main')->name('User_View');
