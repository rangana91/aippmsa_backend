<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function createNewCustomer($data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'number' => $data['number'],
            'address' => $data['address'],
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10)
        ]);
        $user->assignRole('customer');
        return $user;
    }

    public function getUserDetails(): ?Authenticatable
    {
       return Auth::user();
    }

    public function updateUser(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $user->update($request->all());
            return response()->json('User successfully updated.');
        } catch (Exception $exception){
            return response()->json('User update failed.', 400);
        }

    }
}
