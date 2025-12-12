<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'name' => 'Dr. Rahul Mehta',
                'specialization' => 'Cardiologist',
                'email' => 'rahul.mehta@example.com',
                'phone' => '9876543210',
            ],
            [
                'name' => 'Dr. Priya Desai',
                'specialization' => 'Dermatologist',
                'email' => 'priya.desai@example.com',
                'phone' => '9988776655',
            ],
            [
                'name' => 'Dr. Ankit Shah',
                'specialization' => 'Orthopedic Surgeon',
                'email' => 'ankit.shah@example.com',
                'phone' => '9123456780',
            ],
            [
                'name' => 'Dr. Sneha Rao',
                'specialization' => 'Pediatrician',
                'email' => 'sneha.rao@example.com',
                'phone' => '9090909090',
            ],
            [
                'name' => 'Dr. Vikram Patel',
                'specialization' => 'Neurologist',
                'email' => 'vikram.patel@example.com',
                'phone' => '9812345678',
            ],
        ];

        foreach ($doctors as $doc) {
            Doctor::create($doc);
        }
    }
}
