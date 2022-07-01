<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Validators\Auth\LoginValidator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

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

    protected $loginValidator;

    public function __construct(
        LoginValidator $loginValidator
    )
    {
        $this->middleware('guest')->except('logout');
        $this->loginValidator = $loginValidator;
    }

    // 登入頁面
    public function main()
    {
        return view('Auth.Login');
    }

    // 登入驗證
    public function login(Request $request)
    {
        // Validate
        $this->loginValidator->checkLogin($request);

        // 認證帳號密碼
        if(!Auth::attempt($request->only('email','password'))) {
            $message = '電子郵件不存在或密碼錯誤';
            return response()->json([
                'message' => $message,
            ], 401);
        }
        // 檢查Email認證
        if(!Auth::user()->email_verified_at) {
            Auth::logout();
            $message = '尚未驗證電子郵件';
            return response()->json([
                'message' => $message,
            ], 401);
        }
        // 檢查是否帳號狀態是否停用
        if(Auth::user()->expired_at) {
            Auth::logout();
            $message = '該帳號已被停權';
            return response()->json([
                'message' => $message,
            ], 403);
        }

        // 一般使用者
        if(Auth::user()->permission === 1) {
            return response()->json([
                'redirectTarget' => route('User_View')
            ], 200);
        }
        // 一般管理員
        elseif(Auth::user()->permission === 2) {
            return response()->json([
                'redirectTarget' => route('Manager_View')
            ], 200);
        }
        // 最高管理員
        elseif(Auth::user()->permission === 3) {
            return response()->json([
                'redirectTarget' => route('Admin_View')
            ], 200);
        }
    }

    // 登出
    public function logout()
    {
        Auth::logout();
        return redirect()->route('Login_View');
    }
}
