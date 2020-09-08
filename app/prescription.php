<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class prescription extends Model
{
	protected $fillable = [
        'drug_name','times','days',
    ];
	public function consultation() {
        return $this->belongsTo(Consultation::class);
    }
	public function pharmacycustomer() {
        return $this->hasMany(Pharmacycustomer::class);
    }
}
