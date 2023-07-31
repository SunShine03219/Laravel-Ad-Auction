<?php

namespace App\Console\Commands;

use App\Models\Favorite;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class OneDayAuctionExpireNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:one-day-expire-auction';

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
        $expiredAds = Favorite::with(['ad' => function ($query) {
            $query->whereBetween('expired_at', [Carbon::now(), Carbon::now()->addDay(1)]);
        }])->with(['user' => function ($query) {
            $query->where('watch_notify_1day', true);
        }])->get();

        foreach ($expiredAds as $expiredAd) {
            if ($expiredAd->user !== null) {
                $user = $expiredAd->user;
                $data = ['name' => "$user->name"];
                Mail::raw('Hello '.$user->name.', the auction will be expired in 1 day.', function ($message) use ($user) {
                    $message->to($user->email, 'Larabid')->subject('Auction Expired');
                });
            }
        }
    }
}
