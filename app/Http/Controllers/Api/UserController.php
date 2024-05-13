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
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $data = new User();
        $data->username = $request->username;
        $data->password = $request->password;
        $data->email = $request->email;
        $data->nama = $request->nama;
        $data->tanggal_daftar = $request->tanggal_daftar;
        $data->save();

        if ($data) {
            return response()->json([
                'success' => true,
                'user'    => $data,
            ], 201);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'     => 'required',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('username', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau Password Anda salah' 
            ], 401);
        }
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api')->user(),
            'token'   => $token
        ], 200);
    }
}
