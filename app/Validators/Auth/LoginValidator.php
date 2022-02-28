<?php

namespace App\Validators\Auth;

class LoginValidator
{
    // 登入驗證
    public function checkLogin($request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    }
}
