<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Validators\User\UserInformationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class ManagerController extends Controller
{
    protected $user;
    protected $userInformationValidator;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        User $user,
        UserInformationValidator $userInformationValidator
    )
    {
        // 已透過Middleware進行檢查
        // $this->middleware('auth');
        $this->user = $user;
        $this->userInformationValidator = $userInformationValidator;
    }

    /**
     * Show the user homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function main()
    {
        // Get Data
        $userModel = $this->user->where('id', Auth::user()->id)
                                ->first();
        $userCount = $this->user->where('permission', 1)
                                ->count();
        // Processing Data
        $data = [];
        $data['user'] = $userModel;
        $data['userCount'] = $userCount;
        // View
        return view('Manager.ManagerMain', compact('data'));
    }

    public function infomation()
    {
        // Get Data
        $data = $this->user->where('id', Auth::user()->id)
                           ->first();
        // Response
        return view('Manager.UserInformationMain', compact('data'));
    }

    public function update(Request $request)
    {
        // Validate
        $this->userInformationValidator->checkUserInformation($request);
        // Check Password
        if($request['password']) {
            $user = Auth::user();
            if (!Hash::check($request['currentPassword'], $user['password'])) {
                return response('Current Password Wrong', 200);
            }
            else if ($request['password'] !== $request['confirmPassword']) {
                return response('Confirm Password Failed', 200);
            }
            else {
                $newpassword = bcrypt($request['password']);
            }
        }
        // Get Data
        $data = ['name' => $request['name']];
        if(isset($newpassword)) {
            $data["password"] = $newpassword;
        }
        // Update
        try {
            $this->user->where('email', Auth::user()->email)
                       ->update($data);
            $result = [
                'result' => 'successful'
            ];
        } catch (\Exception $e) {
            $result = [
                'result' => 'failure',
                'message' => $e->getMessage()];
        }   
        // Response
        if ($result['result'] === 'successful') {
            return response('Successful', 200);
        }
        elseif ($result['result'] === 'failure') {
            return response('Server Error', 500);
        }
        return response('Bad Request', 400);
    }
}
