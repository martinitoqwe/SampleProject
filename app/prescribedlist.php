<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class prescribedlist extends Model
{
	protected $fillable = [
        'pharmacy_id','consultation_id','prescription_id',
    ];
   	public function prescription(){
		return $this->belongsTo(Prescription::class);
	}
	public function pharmacylist(){
		return $this->belongsTo(Pharmacylist::class);
	}
	public function consultation(){
		return $this->belongsTo(Consultation::class);
	}
}
