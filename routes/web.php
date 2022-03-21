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
 * 後台
 */
Route::group(['prefix' => 'backend', 'middleware' => 'auth'], function() {
    /**
     * 使用者
     */
    Route::group(['prefix' => 'user', 'middleware' => 'user'], function() {
        // 首頁
        Route::get('/', 'User\UserController@main')->name('User_View');
        // 基本資料
        Route::get('/AccountInformation', 'User\UserController@infomation')->name('UserInfomation_View');
        Route::patch('/AccountInformation', 'User\UserController@update')->name('UserInfomation_Update')->middleware('ajax');
        // 專案 
        Route::get('/ProjectManagement', 'User\ProjectController@index')->name('ProjectManagement_View');
        Route::get('/ProjectCreate', 'User\ProjectController@create')->name('ProjectCreate_View');
        Route::post('/ProjectCreate', 'User\ProjectController@store')->name('Project_Create');
        Route::get('/Project/{projectName}', 'User\ProjectController@show')->name('Project_View');
        // 測試腳本
        Route::get('/TestScriptManagement', 'User\TestScriptController@index')->name('TestScriptManagement_View');
        Route::get('/TestScriptCreate', 'User\TestScriptController@create')->name('TestScriptCreate_View');
        Route::post('/TestScriptCreate', 'User\TestScriptController@store')->name('TestScript_Create');
        Route::get('/TestScript/{testScriptName}', 'User\TestScriptController@show')->name('TestScript_View');
        Route::get('/TestScript/Start/{testScriptId}', 'User\TestScriptController@start')->name('TestScript_Start');
    });
    /**
     * 管理員
     */
    Route::group(['prefix' => 'manager', 'middleware' => 'manager'], function() {
        // 首頁
        Route::get('/', 'Manager\ManagerController@main')->name('Manager_View');
    });
});
