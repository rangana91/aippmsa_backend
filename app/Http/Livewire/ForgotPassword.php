<?php

namespace App\Http\Livewire;

use App\services\PasswordResetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Livewire\Component;
use App\Models\User;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;

class ForgotPassword extends Component
{
    use Notifiable;

    public $mailSentAlert = false;
    public $showDemoNotification = false;
    public $email='';
    public $rules=[
        'email' => 'required|email|exists:users'
    ];
    protected $messages = [
        'email.exists' => 'The Email Address must be in our database.',
    ];

    public function mount()
    {
        if (auth()->user()) {
            return redirect()->intended('/dashboard');
        }
    }

    public function updatedEmail()
    {
        $this->validate(['email'=>'required|email|exists:users']);
    }
    public function routeNotificationForMail() {
        return $this->email;
    }
    public function recoverPassword(PasswordResetService $passwordResetService) {
        if(env('IS_DEMO')) {
            $this->showDemoNotification = true;
        }
        else {
            $this->validate();
            $result = $passwordResetService->sendResetLink($this->email);
            $this->mailSentAlert = $result['success'];
        }
    }

    public function render()
    {
        return view('livewire.forgot-password');
    }
}
