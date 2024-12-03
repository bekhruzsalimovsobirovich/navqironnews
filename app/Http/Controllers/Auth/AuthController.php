<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'login' => 'required|exists:users,login',
            'password' => 'required',
        ]);

        // Attempt authentication
        if (Auth::attempt(['login' => $validated['login'], 'password' => $validated['password']])) {
            // Get the authenticated user
            $user = Auth::user();

            // Create token for the authenticated user
            $token = $user->createToken('token-name')->plainTextToken;

            // Return a success response with token and user data
            return $this->successResponse([
                'token' => $token,
            ], new UserResource($user));
        }

        // Return an error response if authentication fails
        return $this->errorResponse('Invalid login or password.', 401);
    }
}
