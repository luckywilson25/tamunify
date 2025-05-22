<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Visitor;
use App\Models\VisitorGeneral;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OneTimeTest extends TestCase
{
    use RefreshDatabase;

   public function test_one_time_visitor_registration_success()
    {
        $this->withoutExceptionHandling();

        Storage::fake('local');
        Notification::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $photo = UploadedFile::fake()->image('photo.jpg');

        $response = $this->post('/one-time', [
            'name' => 'John Doe',
            'identity_number' => '1234567890',
            'company' => 'PT ABC',
            'phone' => '08123456789',
            'email' => 'john@example.com',
            'purpose' => 'Lainnya',
            'purpose_more' => 'IT',
            'person_to_meet' => 'Mr. Manager',
            'department' => 'IT',
            'department_more' => 'IT',
            'visit_date' => now()->format('Y-m-d'),
            'exit_date' => now()->addDay()->format('Y-m-d'),
            'visit_time' => '08:00',
            'exit_time' => '16:00',
            'vehicle_number' => 'B 1234 CD',
            'additional_info' => 'None',
            'photo' => $photo,
        ]);

        $response->assertRedirect('/one-time/success');
    }
}
