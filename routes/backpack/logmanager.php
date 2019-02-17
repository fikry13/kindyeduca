<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'namespace'  => 'Backpack\LogManager\app\Http\Controllers',
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin'), 'role:admin'],
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
], function () { // custom admin routes
    Route::get('log', 'LogController@index');
    Route::get('log/preview/{file_name}', 'LogController@preview');
    Route::get('log/download/{file_name}', 'LogController@download');
    Route::delete('log/delete/{file_name}', 'LogController@delete');
}); // this should be the absolute last line of this file
