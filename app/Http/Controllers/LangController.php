<?php

namespace App\Http\Controllers;

use App\Events\UpdateLangEvent;
use App\Events\UpdateWordNameEvent;
use App\Models\Keyword;
use App\Models\Lang;
use App\Repositories\HelpRepository;
use App\User;
use Illuminate\Http\Request;

class LangController extends Controller
{
    private $updateComment = [
        'status'    => '状态',
        'var_name'  => '变量名',
        'chinese'   => '中文词汇',
        'japanese'  => '日文词汇',
        'person'    => '责任人',
        'sponsor'   => '发起人',
        'description'   => '详细说明',
        'title'     => '需求标题',
        'url'       => '路由',
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
            if(!$request->word['chinese'][$key] || !$request->word['japanese'][$key])
            {
                continue;
            }
            $words[$key]['var_name'] = $var_name;
            $words[$key]['chinese']  = $request->word['chinese'][$key];
            $words[$key]['japanese'] = $request->word['japanese'][$key];
            $words[$key]['lang_id']  = $langId;
            $words[$key]['description'] = $request->description;
            $words[$key]['url']         = e($request->url);
            $words[$key]['person']      = e($request->person);
            $words[$key]['sponsor']     = e($request->sponsor);
        }
        if( ! count($words) )
        {
            return back()->with("message","至少需要完整填写一个词汇！")->with("status",203)->withInput();
        }
        foreach ($words as $value) {
            $id = Keyword::create($value);
        }
        /*
         * 触发事件
         */
        \Event::fire(new UpdateLangEvent(Lang::find($langId)));
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
        $lang = Lang::find($id);
        return view("lang.show",[
            'id'    => $id,
            'lang'  => $lang,
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
        $lang = Lang::find($id);
        $users = User::all();
        return view("lang.edit",[
            'id'    => $id,
            'lang'  => $lang,
            'users' => $users,
            'layui' => true,
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
        \DB::beginTransaction();
        try {
            $lang = [];
            $lang['title'] = e($request->title);
            $lang['description'] = $request->description;
            $lang['url'] = e($request->url);
            $lang['person'] = e($request->person);
            $lang['sponsor'] = e($request->sponsor);
            $lang['status'] = e($request->status);
            $lang['type'] = \Session::get("platform");
            $DbLang = Lang::find($id);

            /*
             * 基础信息是否需要修改
             */
            $updateData = [];
            foreach ($lang as $key => $value) {
                if ($DbLang->$key != $value) {
                    $updateData[$key] = $value;
                }
            }
            /*
             * 2.组装word数组 并向word表中保存数据
             */
            $words = [];
            foreach ($request->word['var_name'] as $key => $var_name) {
                if (!$request->word['chinese'][$key] || !$request->word['japanese'][$key]) {
                    continue;
                }

                $words[$key]['id'] = isset($request->word['id'][$key]) ? $request->word['id'][$key] : null;
                $words[$key]['var_name'] = $var_name;
                $words[$key]['chinese'] = $request->word['chinese'][$key];
                $words[$key]['japanese'] = $request->word['japanese'][$key];
            }
            if (!count($words)) {
                return back()->with("message", "至少需要完整填写一个词汇！")->with("status", 203)->withInput();
            }
            /*
             * 词汇是否有需要修改
             */
            $wordUpdateData = [];
            foreach ($words as $key => $value) {
                /*
                 * 如果没有ID则直接保存， 因为没有ID的都是新编辑加的；
                 */
                if (!$value['id']) {
                    /*
                     * 如果有一点没有数据 则跳过；
                     */
                    if (!$value['japanese'] || !$value['chinese']) {
                        continue;
                    }
                    $wordUpdateData[] = $value;
                    continue;
                }
                $DbWord = Keyword::find($value['id']);
                /*
                 * 修改说明
                 */
                $comment = "修改了 ： ";
                foreach ($value as $k => $v) {
                    if ($DbWord->$k != $v) {
                        $comment .= $this->updateComment[$k] . "、";
                    }
                }
                if ($DbWord->japanese != $value['japanese'] || $DbWord->chinese != $value['chinese']) {
                    $wordUpdateData[] = array_merge($value, [
                        'lang_id' => $id, 'url' => e($request->url), 'status' => 1, 'type' => \Session::get('platform'), 'comment' => $comment . "字段！"
                    ]);
                }
            }
            /*
             * 修改数据
             */
            if (!$updateData && !$wordUpdateData) {
                return back()->with("message", "没有需要修改的数据！")->with("status", 201)->withInput();
            }
            if($updateData)
            {
                /*
                 * 修改说明
                 */
                $comment = [];
                $flag = false;
                foreach ($lang as $key => $value) {
                    if( $DbLang->$key != $value )
                    {
                        $flag = true;
                        $updateArray[$key] = $value;
                        $comment[] = $this->updateComment[$key] ;
                    }
                }
                if( $flag )
                {
                    $commentString = '更新了:'.implode("、",$comment)."。";
                }
                Lang::where('id', $id)->update(array_merge($updateData,['comment'=>$commentString]));

                /*
                 * 触发事件
                 */
                \Event::fire(new UpdateLangEvent(Lang::find($id)));
            }
            if($wordUpdateData) {
                foreach ($wordUpdateData as $value) {
                    if (!$value['id']) {
                        $L = Keyword::create($value);
                    } else {
                        Keyword::where('id', $value['id'])->update($value);
                        $L = Keyword::find($value['id']);
                    }
                    \Event::fire(new UpdateWordNameEvent($L));
                }
            }
            \DB::commit();
            return redirect("lang")->with("message",'修改成功！')->with("status",200);
        }catch (\Exception $e){
            \DB::rollBack();
            return back()->with("message", "服务器在处理过程中遇到了错误，相信原有请查看系统日志！")
                ->with("status", 203)->withInput();
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
