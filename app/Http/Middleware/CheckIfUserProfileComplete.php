<?php

namespace App\Http\Middleware;

use Closure;
use Prologue\Alerts\Facades\Alert;

class CheckIfUserProfileComplete
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
            if(is_null($user->avatar) || is_null($user->latitude) || is_null($user->longitude) || is_null($user->gender) || is_null($user->age) || is_null($user->phone) || is_null($user->address))
            {
                Alert::error('Profil anda belum lengkap!')->flash();

                return redirect()->back();
            }
        }

        return $next($request);
    }
}
