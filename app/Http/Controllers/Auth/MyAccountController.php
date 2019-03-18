<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\ChangeAvatarRequest;
use App\Models\Grade;
use App\Models\Subject;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountInfoRequest;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MyAccountController extends Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->middleware(backpack_middleware());
    }

    /**
     * Show the user a form to change his personal information.
     */
    public function getAccountInfo()
    {
        $user = $this->guard()->user();

        $this->data['title'] = trans('backpack::base.my_account');
        $this->data['user'] = $user;

        if($user->latitude == null && $user->longitude == null)
            Mapper::map(-7.797068, 110.370529);
        else
            Mapper::map($user->latitude, $user->longitude);

        return view('backpack::auth.account.show_info', $this->data);
    }

    /**
     * Show the user a form to change his personal information.
     */
    public function getAccountInfoForm()
    {
        $user = $this->guard()->user();

        $this->data['title'] = trans('backpack::base.my_account');
        $this->data['user'] = $user;
        $this->data['grades'] = Grade::with('school')->get();
        $this->data['subjects'] = Subject::all();

        if($user->latitude == null && $user->longitude == null)
            Mapper::map(-7.797068, 110.370529, ['draggable' => true, 'eventDragEnd' => 'markerDragEnd(event);']);
        else
            Mapper::map($user->latitude, $user->longitude, ['draggable' => true, 'eventDragEnd' => 'markerDragEnd(event);']);

        return view('backpack::auth.account.update_info', $this->data);
    }

    /**
     * Show the user a form to change his personal information.
     */
    public function getAvatarForm()
    {
        $user = $this->guard()->user();

        $this->data['title'] = trans('backpack::base.my_account');
        $this->data['user'] = $user;

        return view('backpack::auth.account.update_avatar', $this->data);
    }


    public function getLocation(Request $request)
    {
        $location = Mapper::location($request->input('location'));
        $data = [
            'status' => 'success',
            'latitude' => $location->getLatitude(),
            'longitude' => $location->getLongitude()
        ];

        return response()->json($data);
    }

    public function postAvatarForm(ChangeAvatarRequest $request)
    {
        $user = $this->guard()->user();

        Storage::disk('avatar')->delete($user->id."/".$user->avatar);

        $explode = explode(',', $request->avatar);
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

        $path = now()->timestamp."-".$user->id.".".$format;

        $user->avatar = $path;
        $user->save();

        $request->merge(['avatar' => $path]);

        $result = $user->update($request->except(['_token']));

        Storage::disk('avatar')->put($user->id."/".$path, base64_decode($explode[1]));

        if ($result) {
            Alert::success(trans('backpack::base.account_updated'))->flash();
        } else {
            Alert::error(trans('backpack::base.error_saving'))->flash();
        }

        return redirect()->back();
    }

        /**
     * Save the modified personal information for a user.
     */
    public function postAccountInfoForm(AccountInfoRequest $request)
    {
        $user = $this->guard()->user();

        $result = $user->update($request->except(['_token']));

        $user->skills()->sync($request->input('skill_id'));

        if ($result) {
            Alert::success(trans('backpack::base.account_updated'))->flash();
        } else {
            Alert::error(trans('backpack::base.error_saving'))->flash();
        }

        return redirect()->back();
    }

    /**
     * Show the user a form to change his login password.
     */
    public function getChangePasswordForm()
    {
        $this->data['title'] = trans('backpack::base.my_account');
        $this->data['user'] = $this->guard()->user();

        return view('backpack::auth.account.change_password', $this->data);
    }

    /**
     * Save the new password for a user.
     */
    public function postChangePasswordForm(ChangePasswordRequest $request)
    {
        $user = $this->guard()->user();
        $user->password = Hash::make($request->new_password);

        if ($user->save()) {
            Alert::success(trans('backpack::base.account_updated'))->flash();
        } else {
            Alert::error(trans('backpack::base.error_saving'))->flash();
        }

        return redirect()->back();
    }

    /**
     * Get the guard to be used for account manipulation.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return backpack_auth();
    }
}
