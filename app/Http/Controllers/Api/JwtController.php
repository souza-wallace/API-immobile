<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JwtController extends Controller
{
    public function login(Request $request){
        try {
            //Auth::attempt(['email' => $email, 'password' => $password]);
            $credentials = $request->all(['email', 'password']);

            if(!auth('api')->attempt($credentials)){
                return response()->json(['Unhatourized' => 'Usuario não autenticado'], 401);
            }else{

                $token = auth('api')->attempt($credentials);

            }
    
            return response()->json([
                'token' => $token
            ]);

        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            return response()->json(['Unhatourized' => $th->getMessage()], 401);
        }
    }
}
