<?php


namespace App\Http\Controllers;

class AdminController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(backpack_middleware());
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user = backpack_auth()->user();

        $this->data['title'] = trans('backpack::base.dashboard'); // set the page title
        if($user->hasRole('teacher'))
            $this->data['sessions'] = $user->teachingSessions()->withAnyStatus()->get();
        elseif ($user->hasRole('student'))
            $this->data['sessions'] = $user->joinedSessions()->withAnyStatus()->get();
        return view('backpack::dashboard', $this->data);
    }

    /**
     * Redirect to the dashboard.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(backpack_url('dashboard'));
    }
}
