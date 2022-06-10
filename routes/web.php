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
        Route::get('/AccountInformation', 'User\UserController@infomation')->name('User_Infomation_View');
        Route::patch('/AccountInformation', 'User\UserController@update')->name('User_Infomation_Update')->middleware('ajax');
        // 專案 
        Route::get('/ProjectManagement', 'User\ProjectController@index')->name('User_ProjectList_View');
        Route::get('/ProjectCreate', 'User\ProjectController@create')->name('User_ProjectCreate_View');
        Route::post('/ProjectCreate', 'User\ProjectController@store')->name('User_Project_Create');
        Route::get('/Project/{projectId}', 'User\ProjectController@show')->name('User_Project_View');
        Route::get('/Project/edit/{projectId}', 'User\ProjectController@edit')->name('User_Project_Edit');
        Route::patch('/Project/{projectId}', 'User\ProjectController@update')->name('User_Project_Update');
        Route::delete('/Project/{projectId}', 'User\ProjectController@destroy')->name('User_Project_Delete');
        // 測試腳本
        Route::get('/TestScriptTutorial', 'User\TestScriptController@tutorial')->name('User_TestScriptTutorial_View');
        Route::get('/TestScriptManagement', 'User\TestScriptController@index')->name('User_TestScriptList_View');
        Route::get('/TestScriptCreate', 'User\TestScriptController@create')->name('User_TestScriptCreate_View');
        Route::post('/TestScriptCreate', 'User\TestScriptController@store')->name('User_TestScript_Create');
        Route::get('/TestScript/{testScriptId}', 'User\TestScriptController@show')->name('User_TestScript_View');
        Route::patch('/TestScript/{testScriptId}', 'User\TestScriptController@update')->name('User_TestScript_Update');
        Route::delete('/TestScript/{testScriptId}', 'User\TestScriptController@destroy')->name('User_TestScript_Delete');
        Route::get('/TestScript/Download/{testScriptId}', 'User\TestScriptController@download')->name('User_TestScript_Download');
        Route::get('/TestScript/Start/{testScriptId}', 'User\TestScriptController@start')->name('User_TestScript_Start');
        // 測試結果
        Route::get('/TestResultList/{testScriptId}', 'User\TestResultController@index')->name('User_TestResultList_View');
        Route::get('/TestResult/{testResultId}', 'User\TestResultController@show')->name('User_TestResult_View');
        Route::delete('/TestResult/{testResultId}', 'User\TestResultController@destroy')->name('User_TestResult_Delete');
    });
    /**
     * 管理員
     */
    Route::group(['prefix' => 'manager', 'middleware' => 'manager'], function() {
        // 首頁
        Route::get('/', 'Manager\ManagerController@main')->name('Manager_View');
        // 使用者管理
        Route::get('/UserManagement', 'Manager\UserManagementController@index')->name('Manager_UserList_View');
        Route::patch('/User/{userId}', 'Manager\UserManagementController@update')->name('Manager_User_Enable');
        Route::delete('/User/{userId}', 'Manager\UserManagementController@destroy')->name('Manager_User_Disable');
    });
});
