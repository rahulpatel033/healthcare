<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    public function rules() {
        return [
            "doctorId" => "required|exists:doctors,id",
            "startTime" => "required|date|after:now",
        ];
    }
}
