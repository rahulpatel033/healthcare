<?php

namespace App\Exceptions;

class InvalidAppointmentException extends ApiExceptions {
    public function __construct(string $message = "")
    {
        return parent::__construct(
            message: $message ? $message : "Invalid Appointment",
            status: 400,
            error: "invalid_appointment"
        );
    }
}