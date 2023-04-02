<?php

namespace App\Http\Controllers\API;

use Validator;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    public function userlogin(Request $request){

        $input = $request->all();

        $validator = Validator::make($input,[

                'email'=> 'required|email|max:100',
                'password'=> 'required'
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages()
                ],422);
            }

            if(Auth::attempt(['email'=>$input['email'],'password'=>$input['password']])){
                $user = Auth::user();

                $token = $user->createToken('Token Name')->accessToken;

                return response()->json(['token'=>$token]);
            }

    }

    public function userDetails(){

        $user=Auth::guard('api')->user();

        return response()->json(['data'=>$user]);

    }
}
