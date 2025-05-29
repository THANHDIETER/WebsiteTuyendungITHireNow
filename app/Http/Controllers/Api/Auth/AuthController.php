<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Welcome to the API. Use /register to create a new user or /login to authenticate.']);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password_hash' => 'required|string|min:6',
            'role' => 'required|in:job_seeker,employer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $user = User::create([
                // 'name'     => $request->name,
                'email'    => $request->email,
                'password_hash' => Hash::make($request->password_hash),
                'role'     => $request->role
            ]);

            $user->assignRole($request->role);

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'message' => 'User registered successfully',
                'user' => [
                    'id'    => $user->id,
                    // 'name'  => $user->name,
                    'email' => $user->email,
                    'role'  => $user->role,
                ],
                // 'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            $user = JWTAuth::setToken($token)->authenticate();

            return response()->json([
                'token' => $token,
                'role' => $user->role,
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                ]
            ], 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
