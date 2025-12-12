<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    const APPOINTMENT_SLOT_DURATION = 15; // slot duration in minutes
    const APPOINTMENT_SLOT_BUFFER = 5; // buffer in minutes
    const APPOINTMENT_CANCEL_WITHIN = 24; // appointment cancel within hours

    const APPOINTMENT_BOOKED_ENUM = "booked";
    const APPOINTMENT_CANCELLED_ENUM = "cancelled";
    const APPOINTMENT_COMPLETED_ENUM = "completed";
    

    protected $fillable = [
        "user_id",
        "doctor_id",
        "start_time",
        "end_time",
        "status",
    ];
}
