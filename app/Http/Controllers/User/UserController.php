<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    protected $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        User $user,
    )
    {
        // 已透過Middleware進行檢查
        // $this->middleware('auth');
        $this->user = $user;
    }

    /**
     * Show the user homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function main()
    {
        return view('User.UserMain');
    }

    public function infomation()
    {
        // Get Data
        // $table = $this->foundationBasicInformationService->getTable(Auth::user()->account, Auth::user()->id, Auth::user()->permissions);
        $data = $this->user->where('email', Auth::user()->email)
                           ->first();
        // Response
        return view('User.UserInformation', compact('data'));
    }

    public function update(Request $request)
    {

    }
}
