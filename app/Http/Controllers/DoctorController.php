<?php
namespace App\Http\Controllers;

use App\Services\DoctorService;

class DoctorController extends Controller
{
    public function __construct(private DoctorService $service) {}

    public function index()
    {
        return response()->json($this->service->getAll());
    }
}
