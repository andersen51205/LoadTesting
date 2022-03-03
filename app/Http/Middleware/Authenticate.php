<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    
    // 繼承自Authenticate 驗證失敗最後會呼叫redirectTo 因此導向至登入頁面
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('Login_View');
        }
    }
}
