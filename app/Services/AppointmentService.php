<?php

namespace App\Services;

use App\DTO\BookAppointmentDTO;
use App\Events\AppointmentBooked;
use App\Exceptions\AppointmentNotFoundException;
use App\Exceptions\DoctorBusyException;
use App\Exceptions\InvalidAppointmentException;
use App\Models\Appointment;
use App\Repositories\AppointmentRepository;
use Illuminate\Support\Carbon;

class AppointmentService {

    public function __construct(private AppointmentRepository $repo)
    {
    }

    public function book(BookAppointmentDTO $dto)
    {
        $start = Carbon::parse($dto->startTime);
        $end = $start->clone()->addMinutes(Appointment::APPOINTMENT_SLOT_DURATION + Appointment::APPOINTMENT_SLOT_BUFFER);
        $dto->endTime = $end->toDateTimeString();
        
        if(!empty($this->repo->isDoctorBusy($dto))) {
            throw new DoctorBusyException();
        }

        if ($this->repo->isUserBusy($dto)) {
            throw new InvalidAppointmentException("You already have an appointment ascheduled for selected time");
        }

        $appointment = $this->repo->create($dto);
        
        AppointmentBooked::dispatch($appointment);
        
        return $appointment;
    }
    
    public function cancel($userId, $id)
    {
        $appointment = $this->repo->find($id);

        if (!$appointment) {
            throw new AppointmentNotFoundException();
        }

        if ($appointment->status === Appointment::APPOINTMENT_COMPLETED_ENUM) {
            throw new InvalidAppointmentException("Appointent has been completed");
        }

        if ($this->repo->isAppointmentWithinHours($id, Appointment::APPOINTMENT_CANCEL_WITHIN)) {
            throw new InvalidAppointmentException("Can't cancel within 24 hours");
        }

        return $this->repo->cancel($userId, $id);
    }

    public function complete($id)
    {
        $appointment = $this->repo->find($id);

        if (!$appointment) {
            throw new AppointmentNotFoundException();
        }

        if($appointment->status === Appointment::APPOINTMENT_CANCELLED_ENUM) {
            throw new InvalidAppointmentException();
        }

        return $this->repo->markCompleted($id);
    }
}