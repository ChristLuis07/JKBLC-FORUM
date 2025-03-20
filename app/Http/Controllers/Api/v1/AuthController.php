<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function register(Request $request)
    {
        $request->validate([
            'name' => "required",
            'email' => "required|email",
            'password' => "required|min:8"
        ]);

        $is_exist_email = User::where("email", $request->email)->first();
        if ($is_exist_email) {
            return response()->json([
                "message" => "Email already exist"
            ], Response::HTTP_CONFLICT);
        }

        try {
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "role" => "user"
            ]);

            $token = $user->createToken("auth_token")->plainTextToken;

            return response()->json([
                "message" => "User created successfully",
                "data" => [
                    "token" => $token,
                    "user" => $user
                ]
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json([
                "message" => "Internal Server Error",
                "error" => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = User::where("email", $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken("auth_token")->plainTextToken;

            return response()->json([
                "message" => "Login successfully",
                "data" => [
                    "token" => $token,
                    "user" => $user
                ]
            ], Response::HTTP_OK);
        }

        return response()->json([
            "message" => "Email or Password is wrong",
        ], Response::HTTP_UNAUTHORIZED);
    }

    function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "message" => "Logout successfully"
        ], Response::HTTP_OK);
    }
}
