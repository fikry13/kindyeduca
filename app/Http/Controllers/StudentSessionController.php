<?php


namespace App\Http\Controllers;

use App\Models\BackpackUser;
use App\Models\Session;
use App\Models\Subject;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use Illuminate\Http\Request;

class StudentSessionController extends Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->middleware(backpack_middleware());
        $this->middleware(['role:student']);
        $this->middleware(['profile.complete']);
        $this->middleware(['user.verified']);
    }

    public function newSession(Request $request)
    {
        Session::create($request->except('_token'));

        return redirect()->action('StudentSessionController@showSessions');
    }

    public function getTeacher(Request $request)
    {
        $user = BackpackUser::find($request->input('id'));

        return response()->json($user, 200);
    }

    public function getSessions(Request $request)
    {
        $user = backpack_auth()->user();

        $teachers = BackpackUser::where('gender', $request->input('gender'))
            ->whereHas('preference',function ($query) use ($request) {
                $query->where('days', 'like', '%'.$request->input('day').'%')
                    ->where('times', 'like', '%'.$request->input('time').'%');
            })
            ->whereHas('skills', function ($query) use ($request) {
                $query->where('id', 'like', $request->input('skill'));
            })->get();

        $teachers = $teachers->filter(function ($teacher) use ($user){
            $pref = $teacher->preference;
            $grade = $pref->grades()->find($user->grade->id);
            $calDis = $this->distance($teacher->latitude, $teacher->longitude, $user->latitude, $user->longitude);
            return ($calDis <= $pref->radius) && ($grade!=null);
        })->values();

        return response()->json($teachers->toArray(), 200);
    }

    function distance($lat1, $lon1, $lat2, $lon2) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        else {
            $pi80 = M_PI / 180;
            $lat1 *= $pi80;
            $lon1 *= $pi80;
            $lat2 *= $pi80;
            $lon2 *= $pi80;

            $r = 6372.797; // mean radius of Earth in km
            $dlat = $lat2 - $lat1;
            $dlng = $lon2 - $lon1;
            $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $km = $r * $c;

            return $km;
        }
    }

    public function findSessions()
    {
        $user = backpack_auth()->user();

        $this->data['title'] = 'Sesi Bimbingan';
        $this->data['sessions'] = $user->joinedSessions()->withAnyStatus()->with(['teacher', 'subject'])->get();
        $this->data['user'] = $user;
        $this->data['subjects'] = Subject::all();
        return view('backpack::page.new-student-session', $this->data);
    }

    public function showSessions()
    {
        $user = backpack_auth()->user();

        $this->data['title'] = 'Sesi Bimbingan';
        $this->data['sessions'] = $user->joinedSessions()->withAnyStatus()->with(['teacher', 'subject'])->get();
        $this->data['user'] = $user;
        $this->data['subjects'] = Subject::all();
        return view('backpack::page.student-sessions', $this->data);
    }

    public function showSession($id)
    {
        $session = Session::withAnyStatus()->with('teacher', 'subject')->find($id);

        $this->data['title'] = 'Detil Sesi Bimbingan';
        $this->data['session'] = $session;

        $teacher = $session->teacher;
        $this->data['student'] = $teacher;
        if ($teacher->latitude == null && $teacher->longitude == null)
            Mapper::map(-7.797068, 110.370529);
        else
            Mapper::map($teacher->latitude, $teacher->longitude);

        return view('backpack::page.session_show', $this->data);
    }
}