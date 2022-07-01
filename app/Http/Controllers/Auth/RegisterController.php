<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        User $user
    )
    {
        $this->middleware('guest');
        $this->user = $user;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('Auth.Register');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Check If Email Exist
        $existUser = $this->user->where('email', $request['email'])
                                ->first();
        if($existUser) {
            return response()->json([
                'message' => '該電子郵件已被註冊'
            ], 401);
        }
        // Processing Data
        $data = [];
        $data['name'] = $request['name'];
        $data['email'] = $request['email'];
        $data['password'] = Hash::make($request['password']);
        // Create Data
        $newProject = User::create($data);
        // Login User
        Auth::attempt($request->only('email','password'));
        // Redirect Route
        return response()->json([
            'redirectTarget' => route('Register_Verify_View')
        ], 200);
    } 
}
