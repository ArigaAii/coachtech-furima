<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureProfileCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        // 未ログインなら、このミドルウェアでは何もしない（authで弾かれる想定）
        if ($user) {
            return $next($request);
        }

        // 未完了ならプロフィール編集へ
        if (!$user->profile_completed) {
        
            if ($request->routeIs('mypage/profile.edit', 'mypage.profile.update')) {
                return $next($request);
            }
        
            $request->sessiion()->put('url.intended', $request->fullUrl());
            return redirect()->route('mypage.profile.edit');
        }

        return $next($request);
    }
}
