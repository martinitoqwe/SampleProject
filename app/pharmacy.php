<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pharmacy extends Model
{
	public function user(){
		return $this->belongsTo(User::class);
	}
	public function pharmacylist(){
		return $this->hasOne(Pharmacylist::class);
	}
}
