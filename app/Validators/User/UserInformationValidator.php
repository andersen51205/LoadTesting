<?php

namespace App\Validators\User;

class UserInformationValidator
{
    // 帳號資料驗證
    public function checkUserInformation($request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'nullable',
        ]);
    }
}
