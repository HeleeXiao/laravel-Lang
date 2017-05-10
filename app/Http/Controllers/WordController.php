<?php

namespace App\Http\Controllers;

use App\Events\UpdateWordNameEvent;
use App\Models\Keyword;
use App\User;
use Illuminate\Http\Request;

class WordController extends Controller
{

    private $updateComment = [
        'status'    => '状态',
        'var_name'  => '变量名',
        'chinese'   => '中文词汇',
        'japanese'  => '日文词汇',
        'person'    => '责任人',
        'sponsor'   => '发起人',
        'description'   => '详细说明',
    ];

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
        $keys = Keyword::where("type",$request->session()->get("platform"));
        if($request->has('keywords') && $request->input('keywords') != "")
        {
            $keys = $keys->Where(function($query) use($request) {
                $query->Where('var_name','like',"%".e($request->input('keywords'))."%")
                ->orWhere('chinese','like',"%".e($request->input('keywords'))."%")
                ->orWhere('japanese','like',"%".e($request->input('keywords'))."%")
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
        return view('keyword.list',['list' => $keys,'request'=>$request,'layui'=>true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('keyword.add',[
            'users' => $users,
            'layui' => true,
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
            'var_name'  => "required|string|unique:keywords",
            'japanese'  => "required|string",
            'chinese'   => "required|string",
            'status'    => "required",
        ],[
            'var_name.required' => "请务必填写变量名",
            'japanese.required' => "请务必填写日文词汇",
            'chinese.required'  => "请务必填写中文词汇",
            'status.required'   => "请务必选择词汇状态",
            'var_name.unique'   => "已经存在该变量名称，请修改",
        ]);
        $id = Keyword::insertGetId([
            'var_name'  => e( trim( $request->input('var_name') ) ),
            'japanese'  => e( trim( $request->input('japanese') ) ),
            'chinese'   => e( trim( $request->input('chinese') ) ),
            'description'   => e( trim( $request->input('description') ) ),
            'status'    => $request->status,
            'person'    => $request->person,
            'sponsor'   => $request->sponsor,
            'type'      => $request->session()->get("platform"),
        ]);
        //触发事件  发送邮件
        \Event::fire(new UpdateWordNameEvent(Keyword::find($id)));
        return redirect("word")->with("message",'添加词汇成功！')->with("status",200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $word = Keyword::find($id);
        return view("keyword.show",[
            'id'    => $id,
            'word'  => $word,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $word = Keyword::find($id);
        $users = User::all();
        return view("keyword.edit",[
            'id'    => $id,
            'word'  => $word,
            'users' => $users,
            "layui" => true
        ]);
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
        $this->validate($request,[
            'var_name'  => "required|string",
            'japanese'  => "required|string",
            'chinese'   => "required|string",
            'status'    => "required",
        ],[
            'var_name.required' => "请务必填写变量名",
            'japanese.required' => "请务必填写日文词汇",
            'chinese.required'  => "请务必填写中文词汇",
            'status.required'   => "请务必选择词汇状态",
        ]);
        $word = Keyword::find($id);
        /*
         * 是否修改标识 真亦真
         */
        $flag = false;
        /*
         * 需要修改的数据
         */
        $updateArray = [];
        /*
         * 修改说明
         */
        $comment = [];
        foreach ($request->all() as $key => $value) {
            if( in_array($key,['_token','_method']) )
            {
                continue;
            }
            if( $word->$key != $value )
            {
                $flag = true;
                $updateArray[$key] = $value;
                $comment[] = $this->updateComment[$key] ;
            }
        }
        if(! $flag )
        {
            return back()->with("message","没有需要修改的数据！")->with("status",203)->withInput();
        }
        $commentString = '更新了:'.implode("、",$comment)."。";
        $updateArray['comment'] = $commentString;
        if( Keyword::where("id",$id)->update($updateArray) )
        {
            //触发事件  发送邮件
            \Event::fire(new UpdateWordNameEvent(Keyword::find($id)));
            return redirect("word")->with("message",'修改成功！')->with("status",200);
        }

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
     * solve the word.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function solve($id)
    {
        Keyword::where('id',$id)->update([
            'comment'   =>NULL,
            'status'    =>2,
        ]);
        return back()->with("message","该词汇的状态已经变更为已解决")->with("status",200);
    }

    /**
     * @name        initKeyWords
     * @DateTime    ${DATE}
     * @param       null.
     * @return      boolean
     * @version     1.0
     * @author      < 18681032630@163.com >
     */
    public function initKeyWords () {
        $chinese = \Lang::get('messages');      //后台数据
        $HChinese = \Lang::get('messages_web'); //前台数据
        \App::setLocale('ja-JP');
        $japanese = \Lang::get('messages');     //后台数据
        $HJapanese = \Lang::get('messages_web');//前台数据
//        dump($chinese);
//        dump($japanese);
//        dump($HChinese);
//        dd($HJapanese);
        \DB::beginTransaction();
        foreach ($chinese as $key => $value) {
            $ins_id = Keyword::updateOrCreate([
                "var_name" => $key ,
                "japanese" => $japanese[$key],
                "chinese"  => $value ,
            ]);
            if( ! $ins_id )
            {
                dd("error");
                \DB::rollBack();
            }
        }
        foreach ($HChinese as $key => $value) {
            $ins_id = Keyword::updateOrCreate([
                "var_name" => $key ,
                "japanese" => $HJapanese[$key],
                "chinese"  => $value ,
                "type"     => 0 ,
            ]);
            if( ! $ins_id )
            {
                dd("error");
                \DB::rollBack();
            }
        }
        \DB::commit();
        dd("OK");
    }
}
