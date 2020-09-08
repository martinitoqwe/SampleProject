<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Auth;
use App\User;
use App\Patient;
use App\Consultation;
use App\Dailyreport;
use App\Notifications\NewReport;
use Illuminate\Support\Facades\Notification;

class UserPatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('patient');
    }
    public function home(Patient $patient){
    	return view('patients.index');
    }
    public function userconsultation(){
        return response()->json(['consultations' => Consultation::with('prescriptions')->where('user_id', auth()->user()->id)->get()->last()]);
    }
    public function store(Request $data, Dailyreport $dailyreport, $id){
        $data = $data->validate([
            'subject' => 'required|string|max:5',
            'body' => 'required|string|max:200',
        ]);
        try {
        $this->validate(request(), [
        'subject' => 'required|string|max:5',
        'body' => 'required|string|max:200',
        ]);
        }
        catch (ValidationException $exception) {
         return response()->json([
            'status' => 'error',
            'message'    => 'Error',
            'errors' => $exception->errors(),
            ], 422);
        }
        $report = new Dailyreport();
        $report->consultation_id = $id;
        $report->subject = $data['subject'];
        $report->body = $data['body'];
        auth()->user()->dailyreports()->save($report);
        $consultation = Consultation::where('id', $id)->get()->first();
        $users = User::where('user_type', 'doctor')->get();
        Notification::send($users, new NewReport(Auth::user(),$consultation));
      //  return redirect()->route('user.index')->with('success', 'Your report was sent successfully');*/
    }
    
}
