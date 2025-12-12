<?php

namespace App\DTO;

class BookAppointmentDTO {
    public function __construct(
        public int $userId,
        public int $doctorId,
        public string $startTime,
        public string $endTime = "",
    ) {}
}