<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consultation;
use App\Prescription;
use App\User;
use App\Prescribedlist;

class PrescriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 	 public function store(Request $data, Consultation $consultation, User $user, Prescribedlist $prescribedlist)
    {
     	$data = $data->validate([
            'drug_name' => 'required|string|max:30',
            'times' => 'required|integer|max:4',
            'days' => 'required|integer|max:14',
        ]);
    	$consultation->prescriptions()->create($data);
        $prescriptions = Prescription::get()->where('consultation_id', $consultation->id);
        $id = $consultation->id;
        foreach($prescriptions as $prescription){           
        }
         Prescribedlist::create([
            'pharmacy_id' => $consultation->user->patient->pharmacy->id,
            'consultation_id' => $prescription->consultation->id,
            'prescription_id' => $prescription->id ,
        ]);
        return redirect()->action('ConsultationController@show', $id)->with('success', 'Prescription successfully added!');
    }
    public function delete(Prescription $prescription){
        $prescription->delete();
        return redirect()->back()->with('success', 'Prescription successfully deleted!');
    }
}
