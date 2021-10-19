<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkshopCertificate extends Model
{
    //
    protected $fillable = [
        'workshop_id', 'user_id', 'certificate_name', 'status',
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function workshopRegistration() {
        return $this->hasOne(WorkshopRegistration::class, 'workshop_id', 'workshop_id');
    }

    public function workshop() {
        return $this->hasOne(Workshop::class, 'id', 'workshop_id');
    }
}
