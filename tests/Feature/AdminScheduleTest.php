<?php

use App\Models\User;
use App\Models\Visitor;
use App\Models\VisitorGeneral;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Carbon\Carbon;

class AdminScheduleTest extends TestCase
{
    public function test_visitor_general_status_is_set_to_inactive_when_exit_time_passed()
    {
        // Buat visitor general dengan waktu sudah lewat
        $visitor = Visitor::factory()->create(['status' => 'Active']);

        VisitorGeneral::factory()->create([
            'visitor_id' => $visitor->id,
            'exit_date' => Carbon::yesterday()->toDateString(),
            'exit_time' => Carbon::now()->format('H:i:s'),
        ]);

        // Jalankan command schedule
        $this->artisan('visitor:check-checkout')->assertExitCode(0);

        // Cek status visitor berubah jadi Inactive
        $this->assertEquals('Inactive', $visitor->fresh()->status);
    }
}
