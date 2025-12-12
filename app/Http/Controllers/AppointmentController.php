<?php

namespace App\Http\Controllers;

use App\DTO\BookAppointmentDTO;
use App\Http\Requests\AppointmentRequest;
use App\Services\AppointmentService;
use Illuminate\Support\Facades\Auth;

class AppointmentController {
    public function __construct(private AppointmentService $service)
    {
    }

    /**
     * Book an appointment
     *
     * This endpoint allows a new user to book an appointment.
     * A valid doctor, from, and to time must be provided.
     *
     * @group Appointment
     * 
     * @header Authorization Bearer {token}
     * 
     * @bodyParam doctorId integer required Doctor ID.
     * @bodyParam startTime string required Start Time. Example: 2025-12-11 10:00:00
     *
     */
    public function book(AppointmentRequest $request)
    {
        $dto = new BookAppointmentDTO(
            userId: Auth::id(),
            doctorId: $request->doctorId,
            startTime: $request->startTime,
        );

        return $this->service->book($dto);
    }

    /**
     * Cancel an appointment
     *
     * This endpoint allows a new user to book an appointment.
     * A valid doctor, from, and to time must be provided.
     *
     * @group Appointment
     * 
     * @header Authorization Bearer {token}
     * 
     * @bodyParam id integer required Appointment ID.
     *
     */
    public function cancel($id)
    {
        return $this->service->cancel(auth()->id(), $id);
    }

    /**
     * Complete an appointment
     *
     * This endpoint allows a new user to book an appointment.
     * A valid doctor, from, and to time must be provided.
     *
     * @group Appointment
     * 
     * @header Authorization Bearer {token}
     * 
     * @bodyParam id integer required Appointment ID.
     *
     */
    public function complete($id)
    {
        return $this->service->complete($id);
    }
}