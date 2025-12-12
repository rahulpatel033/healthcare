<?php

namespace App\Exceptions;

class AppointmentNotFoundException extends ApiExceptions {
    public function __construct()
    {
        return parent::__construct(
            message: "Appointment not found",
            status: 404,
            error: "appointment_not_found"
        );
    }
}