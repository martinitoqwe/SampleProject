<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pharmacylist extends Model
{
   public function pharmacy(){
		return $this->belongsTo(Pharmacy::class);
	}
	public function patients(){
		return $this->hasMany(Patient::class);
	}
	public function prescribedlist(){
		return $this->hasMany(Prescribedlist::class);
	}
}
