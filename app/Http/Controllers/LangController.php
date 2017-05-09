<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use App\Models\Lang;
use App\Repositories\HelpRepository;
use App\User;
use Illuminate\Http\Request;

class LangController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keys = Lang::where("type",$request->session()->get("platform"));
        if($request->has('keywords') && $request->input('keywords') != "")
        {
            $keys = $keys->Where(function($query) use($request) {
                $query->Where('title','like',"%".e($request->input('keywords'))."%")
                    ->orWhere('url','like',"%".e($request->input('keywords'))."%")
                    ->orWhere('id','=',e($request->input('keywords')));
            });
        }
        if($request->has('type')){
            $keys = $keys->where('type',intval($request->input('type')));
        }
        if($request->has('person')){
            $keys = $keys->where('person',intval($request->input('person')));
        }
        if($request->has('sponsor')){
            $keys = $keys->where('sponsor',intval($request->input('sponsor')));
        }
        $limit = $request->has('l') && in_array($request->input('l'),[5,10,20,200]) ?
            $request->input('l')  : 10 ;
        $keys = $keys->orderBy("order",'asc')->orderBy('updated_at','desc')->paginate($limit);
        return view('lang.list',['list' => $keys,'request'=>$request,'layui'=>true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('lang.add',[
            'users' => $users,
            'layui' => true,
            "var_name" => HelpRepository::getVarName(\Session::get("platform"))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'  => "required|string",
            'url'    => "required|url",
            'status'    => "required",
            'description'    => "required",
        ],[
            'title.required' => "请务必填写需求标题",
            'url.required'   => "请务必填写需求页面的url",
            'url.url'       => "格式必须是需求页面的url",
            'status.required'   => "请务必选择词汇状态",
            'description.required'   => "请务必填写需求说明",
        ]);
        /*
         *  1.向Lang表中保存数据
         */
        \DB::beginTransaction();
        $lang = [];
        $lang['title']       = e($request->title);
        $lang['description'] = $request->description;
        $lang['url']         = e($request->url);
        $lang['person']      = e($request->person);
        $lang['sponsor']     = e($request->sponsor);
        $lang['status']      = e($request->status);
        $lang['type']        = \Session::get("platform");

        $langId = Lang::create($lang)->id;
        if(!$langId)
        {
            \DB::rollBack();
            return back()->with("message","添加需求数据失败!")->with("status",203)->withInput();
        }
        /*
         * 2.组装word数组 并向word表中保存数据
         */
        $words = [];
        foreach ($request->word['var_name'] as $key => $var_name) {
            $words[$key]['var_name'] = $var_name;
            $words[$key]['chinese']  = $request->word['chinese'][$key];
            $words[$key]['japanese'] = $request->word['japanese'][$key];
            $words[$key]['lang_id']  = $langId;
            $words[$key]['description'] = $request->description;
        }
        foreach ($words as $value) {
            $id = Keyword::create($value);
        }

        \DB::commit();
        return redirect("lang")->with("message",'添加词汇需求成功！')->with("status",200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd(Lang::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @name        getCreateLangOfTableTbodyTr
     * @DateTime    ${DATE}
     * @param       \Illuminate\Http\Request.
     * @return      \Illuminate\Support\Facades\View
     * @version     1.0
     * @author      < 18681032630@163.com >
     */
    public function getCreateLangOfTableTbodyTr()
    {

        $html = response()->view("lang.CreateLangOfTableTbodyTr",[
            "var_name" => HelpRepository::getVarName(\Session::get("platform"))
        ])->content();
        return response()->json(['html'=>$html]);

    }

}
