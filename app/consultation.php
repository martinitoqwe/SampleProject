<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class consultation extends Model
{
    protected $fillable = [
        'diagnosis','physician_name',
    ];

	public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function prescriptions() {
        return $this->hasMany(Prescription::class);
    }
    public function prescribedlist() {
        return $this->hasMany(Prescribedlist::class);
    }
    public function dailyreports() {
        return $this->hasMany(Dailyreport::class);
    }
}
