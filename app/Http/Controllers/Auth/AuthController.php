<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function updateCredentials(Request $request, User $user)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'login' => 'required|string|max:255|unique:users,login,' . $user->id, // Unique login except current user
            'password' => 'required|string|min:5|confirmed', // Password must have confirmation
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update the user's login and password
        $user->login = $request->input('login');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Revoke old tokens (optional)
        $user->tokens()->delete();

        // Generate a new personal access token
        $token = $user->createToken('auth-token')->plainTextToken;

        // Return a success response with user data and token
        return $this->successResponse([
            'token' => $token,
        ], new UserResource($user));
    }
}
