<?php

namespace App\Repositories;

use App\Models\Doctor;

class DoctorRepository {
    
    public function query()
    {
        return Doctor::query();
    }
}
