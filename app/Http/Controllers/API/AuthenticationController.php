<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Classes\ApiResponse;
class AuthenticationController extends Controller
{
    //User Register Process
    public function register(RegisterRequest $request,$role)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile_number' => $request->mobile_number,
            'role'=>$role
        ]);
        return ApiResponse::sendResponse($user,ucfirst($role) . " registered successfully!",201);
    }
    //User Login Process
    public function login(LoginRequest $request,$role)
    {
        if (Auth::attempt([
            'email' => $request->email, 
            'password' => $request->password,
            'role' => $role // Ensure role matches
        ])) {
            $user = Auth::user();
            $token = $user->createToken('UserApp')->plainTextToken;
             // Prepare the response data
            $responseData = [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile_number' => $user->mobile_number,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                    'role' => $role
                ],
                'token' => $token
            ];
            return ApiResponse::sendResponse($responseData,'User Login successfully!',200);
        }
        return ApiResponse::sendResponse([],'Invalid login details. Please check your username and password.', 401,false);
    }
}
