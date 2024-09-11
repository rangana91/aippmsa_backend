<?php

namespace App\services;

use App\Models\User;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Validator;

class PasswordResetService
{
    public function sendResetLink($email): array
    {
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'message' => 'The Email Address must be in our database.'];
        }

        $user = User::where('email', $email)->first();
        $user->notify(new ResetPassword($user->id));

        return ['success' => true, 'message' => 'Reset link sent successfully.'];
    }
}
