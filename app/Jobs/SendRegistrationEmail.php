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
    protected $email;

    public function __construct(User $user, $email)
    {
        $this->user = $user;
        $this->email = $email;
        Log::info('User email: ' . $this->email); 
    }

    public function handle()
    {
        try {
            if (!empty($this->email)) {
                Log::info('Sending registration email to: ' . $this->email);
                Mail::to($this->email)->send(new RegistrationMail($this->user));
                Log::info('Registration email sent successfully to: ' . $this->email);
            } else {
                Log::error('User email is fucking empty. Cannot send registration email.');
                Log::info('User email: ' . $this->email); 
            }
        } catch (\Exception $e) {
            Log::error('Failed to send registration email: ' . $e->getMessage());
        
        }
    }
}

