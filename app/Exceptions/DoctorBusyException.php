<?php

namespace App\Exceptions;

class DoctorBusyException extends ApiExceptions {
    public function __construct()
    {
        return parent::__construct(
            message: "Slot is not available.",
            status: 400,
            error: "slot_booked"
        );
    }
}