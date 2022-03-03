<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Validators\User\UserInformationValidator;
use Auth;

class UserController extends Controller
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
        // Validate
        $this->userInformationValidator->checkUserInformation($request);

        // Get Data
        $data = [
            'name' => $request['name'],
        ];

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
            dd($result['message']);
            return response('Server Error', 500);
        }
        return response('Bad Request', 400);
    }
}
