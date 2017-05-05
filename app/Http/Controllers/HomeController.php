<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manager.index');
    }

    /**
     * @name        setPlatform 设置前后台
     * @param       \Illuminate\Http\Request. 0 前台 1.后台
     * @return      \Illuminate\Support\Facades\View
     * @version     1.0
     * @author      < 18681032630@163.com >
     */
    public function setPlatform(Request $request)
    {
        if (\Session::exists("platform") )
        {
            \Session::forget("platform");
            \Session::put("platform",$request->platform);
        }else{
            \Session::put("platform",$request->platform);
        }
        session("platform") == 1 ? $message = "后台" : $message = "前台";
        return back()->with("message","系统已切换至$message")->with("status",200);
    }

    public function imageUpload(Request $request)
    {

        $path = $request->file('file')->store(
            'avatars/'.$request->user()->id, 'public'
        );
        return [
            'code' => 0,
            'msg' => 'success',
            "data"=>[
                "src"=> asset("storage/".$path),
                "title" => ""
            ]
        ];
    }
}
