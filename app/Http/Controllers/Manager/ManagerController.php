<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function main()
    {
        return view('Manager.ManagerMain');
    }
}
