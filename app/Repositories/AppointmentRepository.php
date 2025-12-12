<?php

namespace App\Repositories;

use App\DTO\BookAppointmentDTO;
use App\Models\Appointment;

class AppointmentRepository {
    
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

    public function cancel(int $userId, int $id)
    {
        $appointment = Appointment::where("id", $id)
            ->where("user_id", $userId)
            ->firstOrFail();

        $appointment->update(["status" => Appointment::APPOINTMENT_CANCELLED_ENUM]);

        return $appointment;
    }

    public function markCompleted(int $id)
    {
        $appointment = $this->find($id);

        $appointment->update(["status" => Appointment::APPOINTMENT_COMPLETED_ENUM]);
        
        return $appointment;
    }

    public function find(int $id)
    {
        return Appointment::find($id);
    }
    
    public function isAppointmentWithinHours(int $id, int $hours): bool
    {
        $appointment = $this->find($id);

        return $appointment->start_time->diffInHours(now()) < $hours;
    }

}