<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Consultation;
use App\User;
use App\Prescription;
use App\Dailyreport;

class ConsultationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('doctor');
    }
    public function store(Request $request, User $user, Consultation $consultation){
    	
    	 $data = $request->validate([
            'diagnosis' => 'required|string|max:500',
            'physician_name' => 'required',
        ]);
    	$user->consultations()->create($data);
    	$consultation = \App\Consultation::get()->where('user_id', $user->id);
        return redirect()->route('patient.records', compact('user'))->with('consultation', $consultation)->with('success', 'Consultation successfully updated!');
    }
    public function show(Consultation $consultation, Patient $patient, Prescription $prescriptions){
        $prescriptions = Prescription::get()->where('consultation_id', $consultation->id);
        $id = $consultation->id;
    	$consultation = Consultation::get()->where('id', $id);
        $dailyreport = Dailyreport::get()->where('consultation_id', $id);
        return view('consultationview', compact('prescriptions'))->with('consultation', $consultation)->with('dailyreport', $dailyreport);
    }
    public function view($id){
        return response()->json(['consultation' => Consultation::with('user.patient.pharmacy','prescriptions','dailyreports')->where('id', $id)->get()]);
    }
    public function list($id){
        return response()->json(['consultations'=> Consultation::where('user_id', $id)->get()]);

    }
}
