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
        //
    }

    public function verify(Request $request)
    {
        //
    }
}
