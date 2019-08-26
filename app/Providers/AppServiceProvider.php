<?php

namespace App\Providers;

use Backpack\PermissionManager\app\Models\Permission;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
            $explode = explode(',', $value);
            $allow = ['png', 'jpg', 'svg'];
            $format = str_replace(
                [
                    'data:image/',
                    ';',
                    'base64',
                ],
                [
                    '', '', '',
                ],
                $explode[0]
            );

            if (!in_array($format, $allow) || !preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                return false;
            }

            return true;
        });

        Blade::if('hasAvatar', function ()
        {
            $user = backpack_auth()->user();

            return !is_null($user->avatar);
        });

        Blade::if('verifiedUser', function ()
        {
            $user = backpack_auth()->user();

            return $user->verified == 1;
        });

        Blade::if('completeProfile', function()
        {
            $user = backpack_auth()->user();

            return !(($user->hasRole('student') || $user->hasRole('teacher')) && (is_null($user->latitude) || is_null($user->longitude) || is_null($user->gender) || is_null($user->age) || is_null($user->phone) || is_null($user->address)));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
