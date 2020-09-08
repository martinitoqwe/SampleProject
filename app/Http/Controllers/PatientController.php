<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Patient;
use App\Consultation;
use App\Pharmacylist;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('doctor');
    }
    //index of patientshow
    public function index()
    {
        return view('patientshow');
    }
    //storing of patient information
    public function store(Request $data, User $user, Patient $patient, Pharmacylist $pharmacy)
    {
        $data = $data->validate([
            'firstname' => 'required|string|max:30',
            'lastname' => 'required|string|max:30',
            'email' => 'required|email|unique:users,email|max:40',
            'birthday' => 'required|date|max:30',
            'phone' => 'required|regex:/[0-9]{10}/|max:10',
            'address' => 'required|string|max:50',
            'city' => 'required|string|max:15',
            'state' => 'required|alpha|max:2',
            'zip' => 'required|regex:/[0-9]{5}/|max:5',
            'pharmacy' => 'required',
            
        ]);
    	User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['firstname'].$data['lastname']),
        ]);
        $user = \App\User::where('email', $data['email'])->firstOrFail();
        $pharmacy = Pharmacylist::where('pharmacy_name', $data['pharmacy'])->firstOrFail();
       Patient::create([
         	'user_id' => $user->id,
            'birthday' => $data['birthday'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zip' => $data['zip'],
            'pharmacy_id' => $pharmacy->id,
        ]);
         return redirect()->action('HomeController@index')->with('success', 'Patient successfully added!');; 
    }
    //updating patient information
    public function update(Request $data, $id){
        $data = $data->validate([
            'firstname' => 'required|string|max:30',
            'lastname' => 'required|string|max:30',
            'email' => 'required|email|max:40|unique:users,email,'.$id,
            'birthday' => 'required|date|max:30',
            'phone' => 'required|regex:/[0-9]{10}/|max:10',
            'address' => 'required|string|max:50',
            'city' => 'required|string|max:15',
            'state' => 'required|alpha|max:2',
            'zip' => 'required|regex:/[0-9]{5}/|max:5',
            'pharmacy' => 'required',
            
        ]);
        User::where('id', $id)->update([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
        ]);
        $pharmacy = Pharmacylist::where('pharmacy_name', $data['pharmacy'])->firstOrFail();
             Patient::where('user_id', $id)->update([
            'birthday' => $data['birthday'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zip' => $data['zip'],
            'pharmacy_id' => $pharmacy->id,
        ]);
    }
    //get user information
    public function user(Request $request,$id){
    if($request->ajax()){
         return response()->json(['user' => User::with('patient.pharmacy')
            ->where('id', $id)
            ->get(), 'consultations' => Consultation::where('user_id',$id)->get() ]);
    }
    return view('patientshow');
    }
    public function pharmacies(){
        return response()->json(['pharmacies' => Pharmacylist::get()]);
    }
}
