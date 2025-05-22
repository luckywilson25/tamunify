<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\VisitorGeneral;
use Illuminate\Console\Command;
use App\Models\VisitorRecurring;
use App\Models\VisitorInternship;

class CheckVisitorCheckout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visitor:check-checkout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update visitor status to Inactive if checkout time has passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        // === GENERAL ===
        $generals = VisitorGeneral::with('visitor')
            ->whereDate('exit_date', '<=', $now->toDateString())
            ->whereTime('exit_time', '<=', $now->toTimeString())
            ->get();

        foreach ($generals as $general) {
            $general->visitor->update(['status' => 'Inactive']);
        }

        // === INTERNSHIP ===
        $interns = VisitorInternship::with('visitor')
            ->whereDate('internship_end', '<=', $now->toDateString())
            ->get();

        foreach ($interns as $intern) {
            $intern->visitor->update(['status' => 'Inactive']);
        }

        // === RECURRING ===
        $recurrings = VisitorRecurring::with('visitor')
            ->whereDate('access_end', '<=', $now->toDateString())
            ->whereTime('usual_exit_time', '<=', $now->toTimeString())
            ->get();

        foreach ($recurrings as $recurring) {
            $recurring->visitor->update(['status' => 'Inactive']);
        }

        $this->info('Checked all visitors for checkout status.');
        return Command::SUCCESS;
    }
}