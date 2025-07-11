<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "present_address",
        "permanent_address",
        "latitude",
        "longitude",
        "gender",
        "ic_no",
        "registeration_no",
        "current_wokplace",
        "profile_pic",
        "ic_pic",
        "education",
        "birth_date",
        "doctor_designation_id",
        "education_qualification",
        "about",
        "clinic_interest",
        "is_chat",
        "is_video",
        "is_home",
        "is_clinic",
        "home_fee",
        "home_follow_up",
        "home_km_fee",
        "clinic_commission",
        "home_commission",
        "signature",
        "created_by",
        "updated_by",
        "is_active",
        "is_medical_team",
        "doctor_login",
        "appointment_description",
        "rcc_no",
        "timezone",
        "medical_license",
        "medical_certificate",
        "profile_link",
    ];

    protected $casts = [
        'clinic_fee'        => 'decimal:2',
        'clinic_follow_up'  => 'decimal:2',
        'chat_first_time'   => 'decimal:2',
        'chat_follow_up'    => 'decimal:2',
        'video_first_time'  => 'decimal:2',
        'video_follow_up'   => 'decimal:2',
    ];
   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
