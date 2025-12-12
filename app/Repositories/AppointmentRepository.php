<?php

namespace App\Repositories;

use App\DTO\BookAppointmentDTO;
use App\Models\Appointment;

class AppointmentRepository {
    
    /**
     * Check if doctor is busy
     * 
     * This function checks if doctor has already an appointment which
     * overlap with this one 
     * 
     * @param BookAppointmentDTO $dto
     * 
     * @return bool
     */
    public function isDoctorBusy(BookAppointmentDTO $dto)
    {
        $startTime = $dto->startTime;
        $endTime = $dto->endTime;
        
        return Appointment::where("doctor_id", $dto->doctorId)
            ->where(function($query) use ($startTime, $endTime) {
                $query->whereBetween("start_time", [$startTime, $endTime])
                    ->orWhereBetween("end_time", [$startTime, $endTime])
                    ->orWhere(function($query) use ($startTime, $endTime) {
                        $query->where("start_time", "<=", $startTime)
                            ->where("end_time", ">=", $endTime);   
                    });
            })
            ->exists();
    }

    /**
     * Check if user is busy
     * 
     * This function checks if user has already an appointment which would 
     * overlap with this one
     * 
     * @param BookAppointmentDTO $dto
     * 
     * @return bool
     */
    public function isUserBusy(BookAppointmentDTO $dto)
    {
        $startTime = $dto->startTime;
        $endTime = $dto->endTime;
        
        return Appointment::where("user_id", $dto->userId)
            ->where(function($query) use ($startTime, $endTime) {
                $query->whereBetween("start_time", [$startTime, $endTime])
                    ->orWhereBetween("end_time", [$startTime, $endTime])
                    ->orWhere(function($query) use ($startTime, $endTime) {
                        $query->where("start_time", "<=", $startTime)
                            ->where("end_time", ">=", $endTime);   
                    });
            })
            ->exists();
    }

    /**
     * Create an appointment
     * 
     * This function accepts the dto and create an appointment
     * 
     * @param BookAppointmentDTO $dto
     * 
     * @return Appointment appointment details
     */
    public function create(BookAppointmentDTO $dto)
    {
        return Appointment::create([
            "user_id" => $dto->userId,
            "doctor_id" => $dto->doctorId,
            "start_time" => $dto->startTime,
            "end_time" => $dto->endTime,
            "status" => Appointment::APPOINTMENT_BOOKED_ENUM,
        ]);
    }

    /**
     * Cancel the appointment
     * 
     * This function accepts the appointment id and cancelled it
     * 
     * @param int $id
     * 
     * @return Appointment appointment details
     */
    public function cancel(int $id)
    {
        $appointment = $this->find($id);

        $appointment->update(["status" => Appointment::APPOINTMENT_CANCELLED_ENUM]);

        return $appointment;
    }

    /**
     * Accepts the  appointment id and mark it as completed.
     *
     * @param int $id
     * 
     * @return Appointment
     */
    public function markCompleted(int $id)
    {
        $appointment = $this->find($id);

        $appointment->update(["status" => Appointment::APPOINTMENT_COMPLETED_ENUM]);
        
        return $appointment;
    }

    /**
     * Find an appointment by its ID.
     *
     * @param int $id
     * 
     * @return Appointment|null
     */
    public function find(int $id)
    {
        return Appointment::find($id);
    }
    
    /**
     * Determine if an appointment is within the given number of hours from now.
     *
     * Used to restrict cancellation within X hours of start time.
     *
     * @param int $id
     * @param int $hours
     * 
     * @return bool
     */
    public function isAppointmentWithinHours(int $id, int $hours): bool
    {
        $appointment = $this->find($id);

        return $appointment->start_time->diffInHours(now()) < $hours;
    }

}