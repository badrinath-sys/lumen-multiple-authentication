<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function login(Request $request) 
{
    // Validate passed parameters
    $this->validate($request, [
        'email' => 'required',
        'password' => 'required'
    ]);

    // Get the user with the email
    $user = User::where('email', $request['email'])->first();

    // check is user exist
    if (!isset($user)) {
        return response()->json(
            [
                'status' => false,
                'message' => 'User does not exist with this details'
            ]
        );
    }

    // confirm that the password matches
    if (!Hash::check($request['password'], $user['password'])) {
        return response()->json(
            [
                'status' => false,
                'message' => 'Incorrect user credentials'
            ]
        );
    }

    // Generate Token
    $token = $user->createToken('AuthToken')->accessToken;

    // Add Generated token to user column
    User::where('email', $request['email'])->update(array('api_token' => $token));

    return response()->json(
        [
            'status' => true,
            'message' => 'User login successfully',
            'data' => [
                'user' => $user,
                'api_token' => $token
            ]
        ]
    );
}

public function profile() 
{
    $user = Auth::user();

    return response()->json(
        [
            'status' => true,
            'message' => 'User profile',
            'data' => $user
        ]
    );
}

public function all()
{
    $users = User::all();

    return response()->json(
        [
            'status' => true,
            'message' => 'All users',
            'data' => $users
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
        $user=new User();
        $user->name= $request['name'];
        $user->email= $request['email'];
        $user->password= Hash::make($request['password']);
        $user->save();
        return response()->json(
            [
                'status' => true,
                'message' => 'User register success',
                'data' => $user
            ]
        );
        
}
}

