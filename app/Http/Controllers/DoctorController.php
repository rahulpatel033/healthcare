<?php
namespace App\Http\Controllers;

use App\Http\Resources\DoctorResource;
use App\Services\DoctorService;

class DoctorController extends Controller
{
    public function __construct(private DoctorService $service) {}

     /**
     * List of Doctors
     *
     * This endpoint allows a  user to get list of doctors.
     *
     * @group Doctor
     * 
     * @header Authorization string required Bearer token for authentication.
     *
     */
    public function index()
    {
        $doctors = $this->service->getAll();

        return DoctorResource::collection($doctors);
    }
}
