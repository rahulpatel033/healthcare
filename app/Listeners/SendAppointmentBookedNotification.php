<?php

namespace App\Listeners;

use App\Events\AppointmentBooked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendAppointmentBookedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AppointmentBooked $event): void
    {
        $appointment = $event->appointment;

        // Example use-case:
        Log::info("New appointment booked", [
            'appointment_id' => $appointment->id,
            'user_id' => $appointment->user_id,
            'doctor_id' => $appointment->doctor_id,
            'start_time' => $appointment->start_time,
            'end_time' => $appointment->end_time,
        ]);

        // send email notification to user and doctor from here
        
    }
}
