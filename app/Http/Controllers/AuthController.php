<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    //* Login

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'remember_me' => 'boolean'
        ]);

        //* Check validate

        if ($validate->fails()) {
            $res['status'] = 'failed';
            $res['message'] = 'Validation error';
            $res['error'] = $validate->errors();
            $res['data'] = null;

            return response($res);
        }

        $credentials = $request->only('email', 'password');

        // dd(Auth::attempt($credentials));
        if (!Auth::attempt($credentials)) {

            // return 'success';
            $res['status'] = 'failed';
            $res['message'] = 'Unauthorized';
            $res['error'] = 'Unauthorized';
            $res['data'] = null;

            return response($res);
        }
        // else {
        //     return 'failed';
        // }

        $user = $request->user();

        $tokenResult =  $user->createToken('token');
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeek(1);
        }

        $token->save();

        $data = [
            'email' => $request->email,
            'token' => $tokenResult->accessToken,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ];

        $res['status'] = 'success';
        $res['message'] = 'user success to login';
        $res['data'] = $data;

        return response($res);
    }

    //* Logout
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        $res['status'] = 'success';
        $res['message'] = 'user success to logout';
        $res['data'] = null;

        return response($res);
    }

    public function user(Request $request)
    {
        $user = $request->user();

        $res['status'] = 'success';
        $res['message'] = 'user was fetched';
        $res['data'] = $user;

        return response($res);
    }
}
