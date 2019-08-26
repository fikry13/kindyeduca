<?php


namespace App\Http\Controllers;


use App\Models\Grade;
use App\Models\Session;
use App\Models\Subject;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Prologue\Alerts\Facades\Alert;

class OwnerSessionController extends Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->middleware(backpack_middleware());
        $this->middleware(['role:owner|admin']);
    }

    public function showSessions()
    {
        $user = backpack_auth()->user();

        $this->data['title'] = 'Sesi Bimbingan';
        $this->data['sessions'] = Session::withAnyStatus()->with(['student', 'teacher', 'subject'])->get();
        $this->data['user'] = $user;
        $this->data['subjects'] = Subject::all();
        return view('backpack::page.owner_sessions', $this->data);
    }

    public function showSession($id)
    {
        $session = Session::withAnyStatus()->with(['student', 'student.grade', 'teacher', 'subject'])->find($id);

        $this->data['title'] = 'Detil Sesi Bimbingan';
        $this->data['session'] = $session;

        $student = $session->student;

        if ($student->latitude == null && $student->longitude == null)
            Mapper::map(-7.797068, 110.370529);
        else
            Mapper::map($student->latitude, $student->longitude);

        return view('backpack::page.owner_session_show', $this->data);
    }

    public function updateSessionStatus($id, $status)
    {
        $session = Session::withAnyStatus()->find($id);
        if ($status == 0)
            $session->markPending();
        elseif ($status == 1)
            $session->markApproved();
        elseif ($status == 2)
            $session->markRejected();
        elseif ($status == 3)
            $session->markPostponed();
        else
            $session->markPending();

        Alert::success('Status sesi berhasil diubah')->flash();

        return redirect()->back();
    }
}