<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogInAuthRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController
{
    public function logIn(LogInAuthRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()
            ->json(['token' => $token], Response::HTTP_OK);
    }

    public function logOut(): JsonResponse
    {
        $user = Auth::user();

        if (! is_null($user)) {
            $user->tokens()->delete();

            return response()->json([], Response::HTTP_NO_CONTENT);
        }

        return response()->json([], Response::HTTP_UNAUTHORIZED);
    }
}
