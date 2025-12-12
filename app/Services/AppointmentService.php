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

    /**
     * Create an instance of an appointment service
     * 
     * @param AppointmentRepository $repo
     */
    public function __construct(private AppointmentRepository $repo)
    {
    }

    /**
     * Book an appointment
     * 
     * This function accepts the appointment DTO and create a appointment for the user
     * It checks doctor's availability and user's slot conflicts
     * Upon successful booking, it fires and email to both user and doctor
     * 
     * @param BookAppointmentDTO $dto
     * 
     * @return mixed appointment details
     * 
     * @throws DoctorBusyException
     * @throws InvalidAppointmentException
     */
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
    
    /**
     * Cancel the appointment
     * 
     * This function accepts the appointment id and perform the validations and cancels it
     * It checks if appointment exists, already completed or within 24 hours and based on
     * these checks throws exceptions
     * 
     * @return mixed apointment details
     * 
     * @throws AppointmentNotFoundException
     * @throws InvalidAppointmentException - already completed
     * @throws InvalidAppointmentException - within 24 hours
     */
    public function cancel($id)
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

        return $this->repo->cancel($id);
    }

    /**
     * Completes the appointment
     * 
     * This function accepts the appointment id and make it completed if all 
     * validations passed
     * It throws an exceptions if appointment is not found or already cancelled
     * 
     * @return mixed appointment details
     * 
     * @throws AppointmentNotFoundException
     * @throws InvalidAppointmentException
     */
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