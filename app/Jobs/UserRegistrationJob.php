<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class UserRegistrationJob implements ShouldQueue
{
    use Queueable;

    // public $queue = 'emails';
    /**
     * Create a new job instance.
     */
    public function __construct(public $user)
    {
        $this->onQueue('emails');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Email sent to {$this->user->email}");
    }
}
