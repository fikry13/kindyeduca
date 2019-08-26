<?php


namespace App\Http\Controllers;

use App\Models\BackpackUser;
use Prologue\Alerts\Facades\Alert;

class OwnerUserController extends Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->middleware(backpack_middleware());
        $this->middleware(['role:owner|admin']);
    }

    public function showUsers($role)
    {
        if($role == 'admin' || $role == 'owner')
        {
            Alert::error('Anda tidak memiliki akses')->flash();
            return redirect()->action('AdminController@dashboard');
        }

        $user = backpack_auth()->user();

        $users = BackpackUser::role($role)->get();

        if($role == 'teacher' )
            $this->data['usersInSessions'] = BackpackUser::role('student')->has('joinedSessions', '>', 0)->get();
        else if($role == 'student')
            $this->data['usersInSessions'] = BackpackUser::role('teacher')->has('teachingSessions', '>', 0)->get();

        $this->data['title'] = 'Daftar User';
        $this->data['users'] = $users;
        $this->data['user'] = $user;
        $this->data['role'] = $role;
        return view('backpack::page.owner_users', $this->data);
    }

    public function verifyUser($id)
    {
        $user = BackpackUser::find($id);

        $user->verify();

        Alert::success('User berhasil diverifikasi!')->flash();

        return redirect()->back();
    }
}