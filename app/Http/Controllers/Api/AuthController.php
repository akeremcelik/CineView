<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                //'status' => false,
                'message' => $validator->errors()->all()
            ], 500);
        }

        $data = $validator->validated();
        $data["password"] = Hash::make($data["password"]);

        User::create($data);
        return response()->json([
            //'status' => true,
            'message' => 'Kayıt başarılı'
        ], 200);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                //'status' => false,
                'message' => $validator->errors()->all()
            ], 500);
        }

        $data = $validator->validated();
        if(Auth::attempt(['email' => $data["email"], 'password' => $data["password"]])) {
            $token = Auth::user()->createToken('Token')->accessToken;
            return response()->json([
                //'status' => true,
                'message' => 'Giriş başarılı',
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                //'status' => false,
                'message' => 'Kullanıcı adı ya da şifre hatalı'
            ], 500);
        }
    }
}
