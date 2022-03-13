<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request) 
{
  
    // Validate passed parameters
    $this->validate($request, [
        'email' => 'required',
        'password' => 'required'
    ]);

    // Get the admin with the email
    $admin = Admin::where('email', $request['email'])->first();

    // check is user exist
    if (!isset($admin)) {
        return response()->json(
            [
                'status' => false,
                'message' => 'User does not exist with this details'
            ]
        );
    }

    // confirm that the password matches
    if (!Hash::check($request['password'], $admin['password'])) {
        return response()->json(
            [
                'status' => false,
                'message' => 'Incorrect user credentials'
            ]
        );
    }

    // Generate Token
    $token = $admin->createToken('AuthToken')->accessToken;

    // Add Generated token to user column
    Admin::where('email', $request['email'])->update(array('api_token' => $token));

    return response()->json(
        [
            'status' => true,
            'message' => 'User login successfully',
            'data' => [
                'user' => $admin,
                'api_token' => $token
            ]
        ]
    );
}
public function register(Request $request)
{
    $this->validate($request, [
        'name' => 'required',
        'email' => 'required',
        'password' => 'required'
         ]);
        $admin=new Admin();
        $admin->name= $request['name'];
        $admin->email= $request['email'];
        $admin->password= Hash::make($request['password']);
        $admin->save();
        return response()->json(
            [
                'status' => true,
                'message' => 'admin register success',
                'data' => $admin
            ]
        );
        
}
}