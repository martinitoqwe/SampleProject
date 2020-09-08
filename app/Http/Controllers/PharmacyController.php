<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consultation;
use App\Prescribedlist;
use App\Pharmacylist;
use App\User;
use Illuminate\Support\Facades\DB;
class PharmacyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('pharmacy');
    }
     public function home(){
        $pharmacycustomer = Prescribedlist::All()->where('pharmacy_id', auth()->user()->pharmacy->pharmacylist->id);   
    	return view('pharmacy.index', compact('pharmacycustomer'));
    }
        public function list()
    {
        return response()->json(['pharmacylist' => DB::table('prescribedlists')
        	->select('prescribedlists.id','users.firstname','users.lastname','patients.birthday','prescriptions.drug_name','prescriptions.times','prescriptions.days')
    		->join('prescriptions', 'prescribedlists.prescription_id', '=', 'prescriptions.id')
    		->join('consultations', 'prescriptions.consultation_id', '=', 'consultations.id')
    		->join('users', 'consultations.user_id', '=', 'users.id')
    		->join('patients', 'users.id', '=', 'patients.user_id')
     		->where('prescribedlists.status', 0)
     		->where('prescribedlists.pharmacy_id',auth()->user()->pharmacy->pharmacylist->id)
     		->get()]);
    }
    public function search(Request $request)
    {
    	$data = request()->all();
        if ($request->keywords == "")
        {
            $pharmacylist = DB::table('prescribedlists')
            ->select('prescribedlists.id','users.firstname','users.lastname','patients.birthday','prescriptions.drug_name','prescriptions.times','prescriptions.days')
    		->join('prescriptions', 'prescribedlists.prescription_id', '=', 'prescriptions.id')
    		->join('consultations', 'prescriptions.consultation_id', '=', 'consultations.id')
    		->join('users', 'consultations.user_id', '=', 'users.id')
    		->join('patients', 'users.id', '=', 'patients.user_id')
     		->where('prescribedlists.status', '0')
     		->where('prescribedlists.pharmacy_id',auth()->user()->pharmacy->pharmacylist->id)
     		->get();
        }
        else
        {
    		$pharmacylist = DB::table('prescribedlists')
    		->select('prescribedlists.id','users.firstname','users.lastname','patients.birthday','prescriptions.drug_name','prescriptions.times','prescriptions.days')
    		->join('prescriptions', 'prescribedlists.prescription_id', '=', 'prescriptions.id')
    		->join('consultations', 'prescriptions.consultation_id', '=', 'consultations.id')
    		->join('users', 'consultations.user_id', '=', 'users.id')
    		->join('patients', 'users.id', '=', 'patients.user_id')
     		->where('prescribedlists.status', 0)->where('users.firstname',$request->keywords)->orWhere('users.lastname', $request->keywords)->where('prescribedlists.pharmacy_id',auth()->user()->pharmacy->pharmacylist->id)->get();

        }
        return response()
            ->json(json_decode($pharmacylist));
    }
    public function pickup($id){
    	Prescribedlist::where('id', $id)->update([
            'status' => 1]);
    	return redirect()->back();
    }
}
