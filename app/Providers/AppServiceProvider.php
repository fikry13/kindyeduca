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

        Validator::extend('is_base64_png',function($attribute, $value, $params, $validator) {
            $image = base64_decode($value);
            $f = finfo_open();
            $result = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
            return $result == 'image/png';
        });
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
            // check file format
            if (!in_array($format, $allow)) {
                return false;
            }
            // check base64 format
            if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                return false;
            }
            return true;
        });

        Blade::if('completeProfile', function()
        {
            $user = backpack_auth()->user();

            if($user->hasRole('student') || $user->hasRole('teacher'))
            {
                if(is_null($user->avatar))
                    return false;
                if(is_null($user->latitude))
                    return false;
                if(is_null($user->longitude))
                    return false;
                if(is_null($user->gender))
                    return false;
                if(is_null($user->age))
                    return false;
                if(is_null($user->phone))
                    return false;
                if(is_null($user->address))
                    return false;
            }

            return true;
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
