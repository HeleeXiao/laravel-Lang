@extends("layouts.manager")

@section("title","编辑词汇需求 - ".config('app.name'))
@section("content")
    <form id="validation-wizard" action="{{ url('lang/'.$id) }}" method="post" class="form-horizontal form-bordered ui-formwizard" novalidate="novalidate">
            <!-- First Step -->
            {{ csrf_field() }}
            {{ method_field("patch") }}
            <div id="validation-first" class="step ui-formwizard-content" style="display: block;">
                <!-- Step Info -->
                <div class="form-group">
                    <div class="col-xs-12">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active disabled">
                                <a href="javascript:void(0)" class="text-muted">
                                    {{--<i class="fa fa-user"></i>--}}
                                    <i class="fa fa-info-circle"></i>
                                    <strong>编辑词汇需求</strong>
                                </a>
                            </li>
                            {{--<li class="disabled">--}}
                                {{--<a href="javascript:void(0)">--}}
                                    {{--<i class="fa fa-info-circle"></i> <strong>Info</strong>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                        </ul>
                    </div>
                </div>
                <!-- END Step Info -->
                <div class="form-group @if($errors->has("title")) has-error @endif">
                    <label class="col-md-4 control-label" for="example-validation-username">需求标题 <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="example-validation-username" name="title"
                                   class="form-control ui-wizard-content" placeholder="请输入需求标题"
                                   required="" aria-required="true" aria-describedby="example-validation-username-error"
                                   aria-invalid="true" value="{{ $lang->title }}"
                            >
                            <span class="input-group-addon">
                                <i class="gi gi-asterisk"></i>
                            </span>
                        </div>
                        @if($errors->has("title"))
                            <span id="example-validation-username-error" class="help-block animation-slideDown">
                                {{ $errors->first("title") }}！
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group @if($errors->has("url")) has-error @endif">
                    <label class="col-md-4 control-label" for="example-validation-username">页面URL <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="example-validation-username" name="url"
                                   class="form-control ui-wizard-content" placeholder="请输入页面URL"
                                   required="" aria-required="true" aria-describedby="example-validation-username-error"
                                   aria-invalid="true" value="{{ $lang->url }}"
                                    >
                            <span class="input-group-addon">
                                <i class="gi gi-asterisk"></i>
                            </span>
                        </div>
                        @if($errors->has("url"))
                            <span id="example-validation-username-error" class="help-block animation-slideDown">
                                {{ $errors->first("url") }}！
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="example-validation-confirm-password">
                        责任人
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select id="val-skill" name="person" class="form-control" >
                                @foreach( $users as $user )
                                    <option value="{{ $user->id }}"
                                            {{ old("person") ? (old("person") == $user->id ? "selected" : "" ) : ($lang->person == $user->id ? "selected" : "" )  }}
                                            >{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <span class="input-group-addon">
                                <i class="gi gi-asterisk"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="example-validation-confirm-password">
                        发起人
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select id="val-skill" name="sponsor" class="form-control" >
                                @foreach( $users as $user )
                                    <option value="{{ $user->id }}"
                                            {{ old("sponsor") ? (old("sponsor") == $user->id ? "selected" : "" ) : ($lang->sponsor == $user->id ? "selected" : "" )  }}
                                            >{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <span class="input-group-addon">
                                <i class="gi gi-asterisk"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group @if($errors->has("status")) has-error @endif">
                    <label class="col-md-4 control-label" for="example-validation-confirm-password">
                        状态：
                        <span class="text-danger">&nbsp;&nbsp;</span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select id="val-skill" name="status" class="form-control" >
                                <option value="0" {{ $lang->status == 0 ? "selected" : "" }}>正常</option>
                                <option value="1" {{ $lang->status == 1 ? "selected" : "" }}>待处理</option>
                                <option value="2" {{ $lang->status == 2 ? "selected" : "" }}>已处理</option>
                                <option value="3" {{ $lang->status == 3 ? "selected" : "" }}>废弃</option>
                            </select>
                            <span class="input-group-addon">
                                <i class="gi gi-asterisk"></i>
                            </span>
                        </div>
                        @if($errors->has("status"))
                            <span id="example-validation-username-error" class="help-block animation-slideDown">
                                {{ $errors->first("status") }}！
                            </span>
                        @endif
                </div>
            </div>
                <div class="form-group @if($errors->has("var")) has-error @endif">
                    <label class="col-md-4 control-label" for="example-validation-email">
                        翻译变量 :
                    </label>
                    <div class="col-md-9"   style="margin: 0 0 0 15%">
                        <table class="table table-borderless table-vcenter" border="1">
                            <thead>

                            <tr style="height: 18px">
                                <th style="text-align: center;font-size: 14px;width: 33%">变量名</th>
                                <th style="text-align: center;font-size: 14px">中文词汇</th>
                                <th style="text-align: center;font-size: 14px">日文词汇</th>
                            </tr>
                            </thead>
                            <tbody id="var-tbody">
                                @foreach($lang->keyWords as $word)
                                    <tr class="active">
                                        <td>
                                            <input type="hidden" name="word[id][]" value="{{ $word->id }}">
                                            <input type="text" name="word[var_name][]"
                                                   class="form-control ui-wizard-content" placeholder=""
                                                   required="" aria-required="true" aria-describedby="example-validation-username-error"
                                                   aria-invalid="true" value="{{ $word->var_name }}" readonly
                                                    >
                                        </td>
                                        <td>
                                            <input type="text" name="word[chinese][]"
                                                   class="form-control ui-wizard-content" placeholder="请输入中文词汇"
                                                   required="" aria-required="true" aria-describedby="example-validation-username-error"
                                                   aria-invalid="true" value="{{ $word->chinese }}"
                                                    >
                                        </td>
                                        <td>
                                            <input type="text" name="word[japanese][]"
                                                   class="form-control ui-wizard-content" placeholder="请输入日文词汇"
                                                   required="" aria-required="true" aria-describedby="example-validation-username-error"
                                                   aria-invalid="true" value="{{ $word->japanese }}"
                                                    >
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a class="btnbtn btn-sm btn-success" style="float: right"
                           onclick="layer.load(2);getCreateLangOfTableTbodyTr();">
                            <i class="fa fa-plus-square"></i>
                        </a>

                    </div>
                </div>
            <!-- END First Step -->
                <div class="form-group @if($errors->has("description")) has-error @endif">
                    <label class="col-md-4 control-label" for="example-validation-email">
                        详细说明 :
                    </label>
                    @if($errors->has("description"))
                        <span id="example-validation-email-error" class="help-block animation-slideDown">
                                {{ $errors->first("description") }}!
                        </span>
                    @endif
                    <div class="col-md-9"   style="margin: 0 0 0 15%">
                            <textarea id="demo"  name="description" style="display: none;">
                                {!! $lang->description !!}
                            </textarea>
                            <script>
                                layui.use('layedit', function(){
                                    var layedit = layui.layedit;
                                    layedit.set({
                                        uploadImage: {
                                            url: '/home/image-upload?_token={{csrf_token()}}' //接口url
                                            ,type: 'post' //默认post
                                        }
                                    })
                                    //建立编辑器
                                    layedit.build('demo',{});

                                });
                            </script>
                        {{--</div>--}}

                    </div>
                </div>
            <!-- Form Buttons -->
                <div class="form-group form-actions">
                    <div class="col-md-8 col-md-offset-4">
                        {{--<input type="reset" class="btn btn-sm btn-warning ui-wizard-content ui-formwizard-button" id="back3" value="Back" disabled="disabled">--}}
                        <input type="submit" class="btn btn-sm btn-primary ui-wizard-content ui-formwizard-button" id="next3" value="提交">
                    </div>
                </div>
            <!-- END Form Buttons -->
        </form>
@stop

@section('js')

    <script>
        function getCreateLangOfTableTbodyTr()
        {
            $.post('{{ route("get-create-lang-tr") }}',
                    {_token:'{{ csrf_token() }}'},
                    function(result){
                        $('#var-tbody').append(result.html);
                        layer.closeAll();
                    }
            );
        }
    </script>

@stop
