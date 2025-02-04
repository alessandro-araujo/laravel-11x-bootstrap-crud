<?php

namespace App\Jobs;

use App\Mail\SendWelcomeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class JobSendWelcomeEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     * @param array
     */
    public function __construct(private $userArray)
    {
        //
    }

    /**
     * Execute the job.
     * @return void 
     */
    public function handle(): void
    {   
        $requestUser = $this->userArray;
        Mail::to($requestUser['email'])->later(now()->addMinute(), new SendWelcomeEmail($requestUser));
    }
}
