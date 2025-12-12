<?php

namespace Tests\Unit;

use App\DTO\BookAppointmentDTO;
use App\Exceptions\AppointmentNotFoundException;
use App\Exceptions\DoctorBusyException;
use App\Exceptions\InvalidAppointmentException;
use App\Models\Appointment;
use App\Repositories\AppointmentRepository;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Mockery;
use Tests\TestCase;

class AppointmentServiceTest extends TestCase 
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_throws_when_doctor_is_busy()
    {
        $this->expectException(DoctorBusyException::class);

        $repo = Mockery::mock(AppointmentRepository::class);
        $service = new AppointmentService($repo);

        $dto = new BookAppointmentDTO(1,1,"2025-12-12 00:00:00");

        $repo->shouldReceive('isDoctorBusy')->once()->andReturnTrue();

        $service->book($dto);
    }

    public function test_throws_when_user_is_busy()
    {
        $this->expectException(InvalidAppointmentException::class);

        $repo = Mockery::mock(AppointmentRepository::class);
        $service = new AppointmentService($repo);

        $dto = new BookAppointmentDTO(1,1,"2025-12-12 00:00:00");

        $repo->shouldReceive('isDoctorBusy')->once()->andReturnFalse();
        $repo->shouldReceive('isUserBusy')->once()->andReturnTrue();

        $service->book($dto);
    }

    public function test_throws_when_cancelling_appointsment_not_found()
    {
        $this->expectException(AppointmentNotFoundException::class);

        $repo = Mockery::mock(AppointmentRepository::class);
        $service = new AppointmentService($repo);

        $repo->shouldReceive('find')->with(123)->andReturnNull();

        $service->cancel(123);
    }

    public function test_throws_when_cancelling_completed_appointment()
    {
        $this->expectException(AppointmentNotFoundException::class);

        $repo = Mockery::mock(AppointmentRepository::class);
        $service = new AppointmentService($repo);

        $repo->shouldReceive('find')->with(123)->andReturnNull();

        $service->cancel(123);
    }

    public function test_throws_when_cancelling_within_restricted_hours()
    {
        $this->expectException(InvalidAppointmentException::class);

        $repo = Mockery::mock(AppointmentRepository::class);
        $service = new AppointmentService($repo);

        $appointment = (object)[
            'id' => 11,
            'status' => Appointment::APPOINTMENT_BOOKED_ENUM,
            'start_time' => Carbon::now()->addHours(1)
        ];

        $repo->shouldReceive('find')->with(11)->andReturn($appointment);
        $repo->shouldReceive('isAppointmentWithinHours')
            ->with(11, Appointment::APPOINTMENT_CANCEL_WITHIN)
            ->andReturnTrue();

        $service->cancel(11);
    }
}