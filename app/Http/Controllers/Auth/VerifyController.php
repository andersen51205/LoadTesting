<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Cache;
use Carbon\Carbon;

class VerifyController extends Controller
{
    //

    public function show()
    {
        return view('Auth.Verify');
    }

    public function send()
    {
        // Get User
        $userModel = Auth::user();
        // Generate Authentication Code
        $authCode = random_int(100000, 999999);
        // Set Code to Cache, 
        Cache::put($userModel['email'], $authCode, 1800);
        // Sent Email
        $userModel->sendVerifyEmailNotification($authCode);
        // Return Response
        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function verify(Request $request)
    {
        // Get User
        $userModel = Auth::user();
        // Get Authentication Code
        $authCode= (int) $request['authenticationCode'];
        $currentAuthCode = Cache::get($userModel['email']);
        // Check Authentication Code
        if($authCode !== $currentAuthCode) {
            $message = '認證碼錯誤，請重新確認';
            return response()->json([
                'message' => $message,
            ], 401);
        }
        // Update User Data
        $userModel->update([
            'email_verified_at' => Carbon::now()
        ]);
        // Clear Cache
        Cache::forget($userModel['email']);
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
        // 其他
        return response()->json([
            'redirectTarget' => route('Login_View')
        ], 200);
    }
}
