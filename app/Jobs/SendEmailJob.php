<?php

namespace App\Jobs;

use App\Models\Bid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Bid $bid;

    /**
     * Create a new job instance.
     */
    public function __construct(Bid $bid)
    {
        $this->bid = $bid;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $bid = $this->bid->load(['user', 'ad.user']);

        $data = [
            'bid' => $bid,
        ];

        Mail::send('mail', $data, function ($message) use ($bid) {
            $message->to($bid['user']['email'], 'Larabid')->subject('Email Notification');
        });
    }
}
