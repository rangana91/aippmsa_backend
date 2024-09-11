<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
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

    public function getUserDetails(): ?Authenticatable
    {
       return Auth::user();
    }

    public function updateUser(UpdateUserRequest $request): JsonResponse
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
