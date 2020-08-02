<?php

namespace App\Listeners;

use App\Events\GenerateCodeToLogin;
use App\Jobs\SendSmsJob;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendCodeToUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param GenerateCodeToLogin $event
     * @return void
     */
    public function handle(GenerateCodeToLogin $event)
    {
        /** @var User $user */
        $user = $event->getUser();
        Log::info("Login code for {$user->mobile} is {$user->code}");
        SendSmsJob::dispatch($user->mobile, 'your telegram verify code : ' . $user->code);
    }
}
