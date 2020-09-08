<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dailyreport extends Model
{
	protected $fillable = [
    'subject','body',
    ];
     public function consultation() {
        return $this->belongsTo(Consultation::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
