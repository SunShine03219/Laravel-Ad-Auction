<?php

namespace App\Console\Commands;

use App\Models\Ad;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AdUpdateDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ad-update-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $ads = Ad::all();
        foreach ($ads as $ad) {
            $rand_days = rand(20, 90);
            $futureDate = Carbon::now()->addDays($rand_days);
            $ad->update(['expired_at' => $futureDate]);
        }
    }
}
