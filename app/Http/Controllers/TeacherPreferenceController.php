<?php


namespace App\Http\Controllers;


use App\Models\Grade;
use App\Models\Session;
use App\Models\TeacherPreference;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;

class TeacherPreferenceController extends Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->middleware(backpack_middleware());
        $this->middleware(['role:teacher']);
        $this->middleware(['user.verified']);
    }

    public function showSettings()
    {
        $user = backpack_auth()->user();

        $this->data['title'] = 'Pengaturan Bimbingan';

        $preference = $user->preference;

        $preference['days'] = array_map('intval',explode(',',$preference['days']));
        $preference['times'] = array_map('intval',explode(',',$preference['times']));

        $this->data['preference'] = $preference;
        $this->data['user'] = $user;

        $this->data['grades'] = Grade::with('school')->get();
        return view('backpack::page.teacher-preference', $this->data);
    }

    public function updateSettings(Request $request)
    {
        if($request->input('days') == null)
            $request->merge(['days' => '']);
        else
            $request->merge(['days' => implode(',', $request->input('days'))]);
        if($request->input('times') == null)
            $request->merge(['times' => '']);
        else
            $request->merge(['times' => implode(',', $request->input('times'))]);

        $user = backpack_auth()->user();

        $result = $user->preference->update($request->all());

        $user->preference->grades()->sync($request->input('grade_id'));

        if ($result) {
            Alert::success('Preferensi Berhasil Diubah')->flash();
        } else {
            Alert::error('Preferensi Gagal Diubah')->flash();
        }

        return redirect()->back();

    }
}