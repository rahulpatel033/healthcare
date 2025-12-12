<?php

namespace App\Services;

use App\Repositories\DoctorRepository;

class DoctorService {
    public function __construct(private DoctorRepository $repo){}

    public function getAll(int $limit = 10)
    {
        return $this->repo->query()->paginate($limit);
    }
}