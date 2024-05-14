<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function registerStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username'      => 'required|unique:users',
            'password'  => 'required|min:5',
            'email'     => 'required|email|unique:users',
            'nama'  => 'required|min:5',
            'tanggal_daftar'  => 'required|date'
        ]);


        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create user
        $user = User::create([
            'username'      => $request->username,
            'password'  => bcrypt($request->password),
            'email'     => $request->email,
            'nama'     => $request->nama,
            'tanggal_daftar'     => $request->tanggal_daftar
        ]);

        //return response JSON user is created
        if($user) {
            return response()->json([
                'success' => true,
                'user'    => $user,  
            ], 201);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function login(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'username'     => 'required',
            'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('username', 'password');

        //if auth failed
        if(!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau Password Anda salah'
            ], 401);
        }

        //if auth success
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api')->user(),    
            'token'   => $token   
        ], 200);
    }
}
