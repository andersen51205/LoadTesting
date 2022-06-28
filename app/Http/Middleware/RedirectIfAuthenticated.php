<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    
    // 載入登入頁面時 檢查session是否已登入並導向對應頁面
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // 已登入
                if(Auth::user()->permission === 1) {
                    // 使用者
                    return redirect()->route('User_View');
                }
                elseif(Auth::user()->permission === 2) {
                    // 管理員
                    return redirect()->route('Manager_View');
                }
                elseif(Auth::user()->permission === 3) {
                    // Admin
                    return redirect()->route('Admin_View');
                }
            }
        }
        return $next($request);
    }
}
