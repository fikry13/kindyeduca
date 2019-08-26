<?php

namespace App\Http\Middleware;

use Closure;
use Prologue\Alerts\Facades\Alert;

class CheckIfUserVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = backpack_auth()->user();

        if($user->hasRole('student') || $user->hasRole('teacher'))
        {
            if($user->verified == 0)
            {
                Alert::error('Profil anda belum di verifikasi Admin!')->flash();

                return redirect()->back();
            }
        }

        return $next($request);
    }
}
