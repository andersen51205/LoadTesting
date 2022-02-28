<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // 登入頁面
    public function main()
    {
        return view('Auth.Login');
    }

    // 登入驗證
    public function login(Request $request)
    {

        // 認證帳號密碼
        if (Auth::attempt($request->only('email','password'))) {
            // 認證通過...
            $message = 'Success';
        }
        else {
            $this->incrementLoginAttempts($request);
            $message = 'Username_Or_Password_Wrong';
        }
        // Response
        switch ($message) {
            case 'Success':
                if(Auth::user()->permission === 1) {
                    // 使用者
                    return redirect()->route('User_View');
                }
                elseif(Auth::user()->permission === 2) {
                    // 管理員
                    return redirect()->route('Manager_View');
                }
                break;
            case 'Username_Or_Password_Wrong':
                // 帳密認證失敗
                return redirect()->back()->withInput()->withErrors(['error' => '電子郵件不存在或密碼錯誤']);
                break;
        }
    }

    // 登出
    public function logout()
    {
        Auth::logout();
        return redirect()->route('Login_View');
    }
}
