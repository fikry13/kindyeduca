<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'namespace'  => 'Backpack\Base\app\Http\Controllers',
    'middleware' => 'web',
    'prefix'     => config('backpack.base.route_prefix'),
], function () {

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('backpack.auth.password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('backpack.auth.password.reset.token');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('backpack.auth.password.email');

    Route::get('change-password', 'Auth\MyAccountController@getChangePasswordForm')->name('backpack.account.password');
    Route::post('change-password', 'Auth\MyAccountController@postChangePasswordForm');
}); // this should be the absolute last line of this file
Route::group([
    'namespace'  => 'App\Http\Controllers',
    'middleware' => 'web',
    'prefix'     => config('backpack.base.route_prefix'),
], function () {

    Route::get('dashboard', 'AdminController@dashboard')->name('backpack.dashboard');
    Route::get('/', 'AdminController@redirect')->name('backpack');

    Route::get('show-account-info', 'Auth\MyAccountController@getAccountInfo')->name('backpack.account.show');
    Route::get('edit-profile-picture', 'Auth\MyAccountController@getAvatarForm')->name('backpack.account.avatar');
    Route::post('edit-profile-picture', 'Auth\MyAccountController@postAvatarForm');
    Route::get('edit-account-info', 'Auth\MyAccountController@getAccountInfoForm')->name('backpack.account.info');
    Route::post('edit-account-info', 'Auth\MyAccountController@postAccountInfoForm');
    Route::post('get-location', 'Auth\MyAccountController@getLocation')->name('get-location');

    // Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('backpack.auth.login');
    Route::post('login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->name('backpack.auth.logout');
    Route::post('logout', 'Auth\LoginController@logout');

    // Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('backpack.auth.register');
    Route::post('register', 'Auth\RegisterController@register');

    Route::get('register-public', 'Auth\RegisterController@showPublicRegistrationForm')->name('backpack.auth.register_public');
    Route::post('register-public', 'Auth\RegisterController@registerPublic');

    //Session
    Route::get('new-student-sessions', 'StudentSessionController@findSessions')->name('backpack.page.new-student-session');
    Route::get('new-student-sessions/find', 'StudentSessionController@getSessions')->name('backpack.page.new-student-session.get');
    Route::post('new-student-sessions', 'StudentSessionController@newSession')->name('backpack.page.new-student-session.add');
    Route::get('new-student-sessions/find-teacher', 'StudentSessionController@getTeacher')->name('backpack.page.new-student-session.get-teacher');
    Route::get('student-sessions', 'StudentSessionController@showSessions')->name('backpack.page.student-sessions');
    Route::get('student-sessions/{id}', 'StudentSessionController@showSession')->name('backpack.page.student-session');
    Route::get('sessions', 'SessionController@showSessions')->name('backpack.page.sessions');
    Route::get('sessions/{id}', 'SessionController@showSession')->name('backpack.page.session');
    Route::get('sessions/{id}/{status}', 'SessionController@updateSessionStatus')->name('backpack.page.session_status');
    Route::get('owner-sessions', 'OwnerSessionController@showSessions')->name('backpack.page.owner.sessions');
    Route::get('owner-sessions/{id}', 'OwnerSessionController@showSession')->name('backpack.page.owner.session');
    Route::get('owner-sessions/{id}/{status}', 'OwnerSessionController@updateSessionStatus')->name('backpack.page.owner.session_status');

    //OwnerUsers
    Route::get('owner-users/{role}', 'OwnerUserController@showUsers')->name('backpack.page.owner.users');
    Route::get('users/{id}', 'UserController@showUser')->name('backpack.page.user');
    Route::post('users/{id}/verify', 'OwnerUserController@verifyUser')->name('backpack.page.verify-user');

    //Teacher Settings
    Route::get('teacher-preference', 'TeacherPreferenceController@showSettings')->name('backpack.page.teacher_preference')->middleware('role:teacher');
    Route::post('teacher-preference', 'TeacherPreferenceController@updateSettings')->middleware('role:teacher');

    //Subjects
    Route::get('owner-subjects', 'OwnerSubjectController@index')->name('backpack.page.owner.subjects.index');
    Route::get('owner-subjects-add', 'OwnerSubjectController@add')->name('backpack.page.owner.subjects.add');
    Route::get('owner-subjects/{id}', 'OwnerSubjectController@edit')->name('backpack.page.owner.subjects.edit');
    Route::post('owner-subjects', 'OwnerSubjectController@create')->name('backpack.page.owner.subjects.create');
    Route::patch('owner-subjects/{id}', 'OwnerSubjectController@update')->name('backpack.page.owner.subjects.update');
    //Route::delete('owner-subjects/{id}', 'OwnerSubjectController@delete')->name('backpack.page.owner.subjects.delete');

}); // this should be the absolute last line of this file