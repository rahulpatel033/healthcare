<?php

namespace App\Repositories;

use App\Models\Doctor;

class DoctorRepository {
    /**
     * Returns the doctor query
     * 
     * @return mixed doctor query
     */
    public function query()
    {
        return Doctor::query();
    }
}
