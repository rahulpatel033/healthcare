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
     * @header Authorization Bearer {token}
     *
     */
    public function index()
    {
        $doctors = $this->service->getAll();

        return DoctorResource::collection($doctors);
    }
}
