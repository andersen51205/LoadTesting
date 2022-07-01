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
        //
    }
}
