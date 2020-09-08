<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Notification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('doctor');
    }
    public function index()
    {
        $users = User::where('user_type', 'patient')->get();
        $notifications = auth()->user()->unreadNotifications;
        return view('home', compact('users'))
            ->with('notifications', $notifications);
    }
    public function list()
    {
        return response()->json(['users' => User::with('patient')
            ->where('user_type', 'patient')
            ->get()]);
    }
    public function search(Request $request)
    {
        if ($request->keywords == "")
        {
            $users = User::with('patient')->where('user_type', 'patient')
                ->get();
        }
        else
        {
            $users = User::with('patient')->where('firstname', $request->keywords)
                ->orWhere('lastname', $request->keywords)
                ->get();
        }
        return response()
            ->json(json_decode($users));
    }
    public function notification()
    {
        $notifications = User::where('notifiable_id', auth()->user()
            ->id)
            ->whereNull('read_at')
            ->get();
        dd($notifications);
        return response()->json(['notifications' => auth()
            ->user()->notifications]);
    }
    public function readnotification($id)
    {
        $notification = DB::table('notifications')->where('data->consultation_id', $id)->update(['read_at' => now() ]);
        return redirect()
            ->action('ConsultationController@show', $id);
    }
}

