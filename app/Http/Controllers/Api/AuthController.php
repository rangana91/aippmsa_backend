<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\MobileApiLoginRequest;
use App\Models\User;
use App\services\PasswordResetService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(MobileApiLoginRequest $request): JsonResponse
    {

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 403);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function sendResetLinkEmail(Request $request): JsonResponse
    {
        try{
            $email = $request->input('email');
            $result = (new PasswordResetService())->sendResetLink($email);

            return response()->json([
                'success' => $result['success'],
                'message' => $result['message']
            ]);
        } catch (Exception $exception){
            Log::error($exception);
            return response()->json(['message' => 'Unable to send reset link'], 400);
        }
    }

    public function register(CreateUserRequest $request): JsonResponse
    {
        $address = null;
        if ($request->filled('address_line_1') || $request->filled('address_line_2')) {
            $address = trim($request->address_line_1 . ' ' . $request->address_line_2);
        }

        $request->merge(['address' => $address]);
        $user = User::create($request->except(['address_line_1', 'address_line_2', 'password_confirmation']));
        $user->assignRole('customer');

        return response()->json([
            'message' => 'User created successfully.',
            'user' => $user,
        ], 201);
    }
}
