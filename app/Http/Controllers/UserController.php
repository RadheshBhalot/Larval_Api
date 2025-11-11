<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        return view('welcome');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required',
            'mobileNumber' => 'required',
            'address'      => 'required',
        ]);

        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'mobileNumber' => $request->mobileNumber,
            'address' => $request->address,
        ]);
        // dd($request->all());
        return response()->json([
            'success' => 'user successfully register',
            'user' => $user,
        ]);   //api ke time

    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createtoken('Api token')->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => 'user login Succesfully',
                'token' => $token,
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'message' => 'Something went wrong ',
                'status' => false,
            ], 401);
        }

        return $request->json([
            'status' => false,
        ]);
    }
    public function home()
    {
        try {
            return response()->json([
                'message' => 'Welcome to my app',
                'status'  => true,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'status'  => false,
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6',
            'mobileNumber' => 'required',
            'address'      => 'required',
        ]);
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'User not found',
            ], 404);
        }

        $user->update([
            'name'         => $request->name,
            'email'        => $request->email,
            'password' =>  Hash::make($request->password),
            'mobileNumber' => $request->mobileNumber,
            'address'      => $request->address,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'User successfully updated',
            'user'    => $user,
        ], 200);
    }

    
    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'User Delete sucessfully !',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }
    }
};
