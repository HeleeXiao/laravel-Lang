<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @auther <Helee>
     */
    public function login(Request $request)
    {
        if( !$request->has('username') || !$request->has('password')){
            return response()->json(['status'=>203,'message'=>'必须传递用户名和密码','result'=>[]]);
        }
        if(\Auth::attempt([
                'name'=>e($request->input("username")) ,
                'password' => e($request->input("password"))
            ])|| \Auth::attempt([
                'email' => e($request->input("username")),
                'password' => e($request->input("password"))
            ]))
        {
            return response()->json(['status'=>0,'message'=>'OK','result'=>[]]);
        }
        return response()->json(['status'=>203,'message'=>'账号或密码不正确','result'=>[]]);

    }
}
