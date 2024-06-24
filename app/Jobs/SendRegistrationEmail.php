<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationMail;
use Illuminate\Support\Facades\Log;

class SendRegistrationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        try {
            if (!empty($this->user->email)) {
                Log::info('Sending registration email to: ' . $this->user->email);
                Mail::to($this->user->email)->send(new RegistrationMail($this->user));
                Log::info('Registration email sent successfully to: ' . $this->user->email);
            } else {
                Log::error('User email is empty. Cannot send registration email.');
            }
        } catch (\Exception $e) {
            Log::error('Failed to send registration email: ' . $e->getMessage());
        }
    }
}
