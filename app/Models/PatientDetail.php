<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientDetail extends Model
{
    protected $table = 'patient_details';

    protected $fillable = [
        'user_id',
        'country_code',
        'mobile_no',
        'gender',
        'birth_date',
        'present_address',
        'permanent_address',
        'image',
        'id_proof',
        'created_by',
        'is_active',
        'pat_lat',
        'pat_long',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: PatientDetail belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: created_by user (optional)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
