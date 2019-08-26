<?php


namespace App\Http\Controllers;


use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use Prologue\Alerts\Facades\Alert;

class OwnerSubjectController extends Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->middleware(backpack_middleware());
        $this->middleware(['role:owner|admin']);
    }

    public function index()
    {
        $user = backpack_auth()->user();

        $this->data['title'] = 'Daftar Mata Pelajaran';
        $this->data['subjects'] = Subject::with('sessions')->get();
        $this->data['user'] = $user;
        return view('backpack::page.subjects.index', $this->data);
    }

    public function add()
    {
        return view('backpack::page.subjects.add');
    }

    public function create(SubjectRequest $request)
    {
        $result = Subject::create($request->except('_token'));

        if ($result) {
            Alert::success('Mata pelajaran berhasil dibuat')->flash();
        } else {
            Alert::error('Mata pelajaran gagal dibuat!')->flash();
        }

        return redirect()->route('backpack.page.owner.subjects.index');
    }

    public function edit($id)
    {
        $subject = Subject::find($id);

        $this->data['title'] = 'Detil Sesi Bimbingan';
        $this->data['subject'] = $subject;
        return view('backpack::page.subjects.edit', $this->data);
    }

    public function update($id, SubjectRequest $request)
    {
        $subject = Subject::find($id);

        $result = $subject->update($request->except('_token'));

        if ($result) {
            Alert::success('Mata pelajaran berhasil diubah')->flash();
        } else {
            Alert::error('Mata pelajaran gagal diubah!')->flash();
        }

        return redirect()->route('backpack.page.owner.subjects.index');
    }

    public function delete($id)
    {
        $result = Subject::destroy($id);

        if ($result) {
            Alert::success('Mata pelajaran berhasil dihapus!')->flash();
        } else {
            Alert::error('Mata pelajaran gagal dihapusba!')->flash();
        }

        return redirect()->route('backpack.page.owner.subjects.index');
    }
}