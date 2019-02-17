<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'namespace'  => 'Backpack\Settings\app\Http\Controllers',
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin'), 'role:admin'],
], function () { // custom admin routes
    CRUD::resource('setting', 'SettingCrudController');
}); // this should be the absolute last line of this file
