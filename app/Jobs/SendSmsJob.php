<?php

namespace App\Jobs;

use App\H;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var string
     */
    private $mobileNumber;
    /**
     * @var string
     */
    private $message;

    /**
     * Create a new job instance.
     *
     * @param string $mobileNumber
     * @param string $message
     */
    public function __construct(string $mobileNumber, string $message)
    {
        //
        $this->mobileNumber = $mobileNumber;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        H::sendSms($this->mobileNumber, $this->message);
    }
}
