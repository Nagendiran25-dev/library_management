<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Classes\ApiResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
class UserController extends Controller
{
    /**
     * Display All User Details With Staus and Pagination  Based
    */
    public function getAllUsers(Request $request)
    {
        // Get the status from the request, if it's provided
        $status = $request->get('status');
        $perPage = $request->get('per_page', 15);
        // Query 
        $query = User::query();
        if ($status) {
            $query->where('status', $status);
        }
        $query->where('role','user');
        // Paginate the results
        $users = $query->paginate($perPage);
        return ApiResponse::sendResponse($users,'User Details!',200);
    }
    /**
     * Update the User Status
    */
    public function updateUserStatus(Request $request)
    {
        $rules = [
            'user_id' => 'required|integer|exists:users,id', 
            'status' => 'required|integer',
        ];    
        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Return a custom error response
            return ApiResponse::sendResponse($validator->errors(),'Validation errors',400,false);
        }
        try {
            $validated = $validator->validated();
            // Update user status
            $user = User::findOrFail($validated['user_id']);
            $user->status = $validated['status'];
            $user->save();

            // Return a success response
            return ApiResponse::sendResponse($user, 'User status updated successfully', 200);
        } catch (\Exception $ex) {
            // Handle any exceptions or errors
            return ApiResponse::throw($ex);
        }
    }

}
