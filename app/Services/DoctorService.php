<?php

namespace App\Services;

use App\Repositories\DoctorRepository;

class DoctorService {
    /**
     * create a new doctor service instance
     * 
     * @param DoctorRepository $repo
     */
    public function __construct(private DoctorRepository $repo){}

    /**
     * Get doctors list
     * 
     * This function returns doctors list with limit of 10
     * 
     * @return mixed list of doctors
     */
    public function getAll(int $limit = 10)
    {
        return $this->repo->query()->paginate($limit);
    }
}