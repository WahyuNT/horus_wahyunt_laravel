<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

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
            $errorMessages = implode(', ', $validator->errors()->all());
            return response()->json(['errors' => $errorMessages], 422);
        }

      
        $user = User::create([
            'username'      => $request->username,
            'password'  => bcrypt($request->password),
            'email'     => $request->email,
            'nama'     => $request->nama,
            'tanggal_daftar'     => $request->tanggal_daftar
        ]);

       
        if($user) {
            return response()->json([
                'success' => true,
                'user'    => $user,  
            ], 201);
        }

 
        return response()->json([
            'success' => false,
        ], 409);
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

    
        if(!$token = auth()->guard('api')->attempt($credentials)) {
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

    public function logout()
    {        
      
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if($removeToken) {
         
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil!',  
            ]);
        }
    }
    

}
