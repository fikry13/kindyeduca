<?php


namespace App\Http\Controllers;


use App\Models\BackpackUser;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;

class UserController extends Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->middleware(backpack_middleware());
        //$this->middleware('user.verified');
        //$this->middleware('profile.complete');
    }

    public function showUser($id)
    {
        $logInUser = backpack_auth()->user();

        $user = BackpackUser::find($id);

        if($logInUser == $user)
            $user = $logInUser;

        $this->data['title'] = 'Profil '. $user->name;
        $this->data['user'] = $user;

        if ($user->latitude == null && $user->longitude == null)
            Mapper::map(-7.797068, 110.370529);
        else
            Mapper::map($user->latitude, $user->longitude);

        if($logInUser == $user)
            return view('backpack::base.auth.account.show_info', $this->data);
        else
            return view('backpack::page.user_info', $this->data);
    }
}