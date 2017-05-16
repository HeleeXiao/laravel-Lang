@extends("layouts.manager")

@section("title","修改词汇 - ".config('app.name'))
@section("content")
    <form id="validation-wizard" action="{{ url('word/'.$id) }}" method="post"
          class="form-horizontal form-bordered ui-formwizard" novalidate="novalidate">
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
                                    <strong>修改词汇</strong>
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
                <div class="form-group @if($errors->has("var_name")) has-error @endif">
                    <label class="col-md-4 control-label" for="example-validation-username">变量名 <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="example-validation-username" name="var_name"
                                   class="form-control ui-wizard-content" placeholder="请输入权限名称"
                                   required="" aria-required="true" aria-describedby="example-validation-username-error"
                                   aria-invalid="true" value="{{ old('var_name') ?: $word->var_name }}"
                            >
                            <span class="input-group-addon">
                                <i class="gi gi-asterisk"></i>
                            </span>
                        </div>
                        @if($errors->has("var_name"))
                            <span id="example-validation-username-error" class="help-block animation-slideDown">
                                {{ $errors->first("var_name") }}！
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has("chinese")) has-error @endif">
                    <label class="col-md-4 control-label" for="example-validation-password">
                        中文词汇
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="example-validation-password" name="chinese"
                                   class="form-control ui-wizard-content" placeholder="请输入中文词汇"
                                   required="" value="{{ old('chinese') ?: $word->chinese  }}"
                                   aria-required="true" aria-describedby="example-validation-password-error"
                                   aria-invalid="true" >
                            <span class="input-group-addon">
                                <i class="gi gi-asterisk"></i>
                            </span>
                        </div>
                        @if($errors->has("chinese"))
                            <span id="example-validation-password-error" class="help-block animation-slideDown">
                                {{ $errors->first("chinese") }}！
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group @if($errors->has("japanese")) has-error @endif">
                    <label class="col-md-4 control-label" for="example-validation-email">
                        日文词汇
                        <span class="text-danger">*</span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="example-validation-email" name="japanese"
                                   class="form-control ui-wizard-content" placeholder="请输入日文词汇"
                                   required="" aria-required="true" aria-describedby="example-validation-email-error"
                                   aria-invalid="true" value="{{ old('japanese') ?: $word->japanese  }}">
                            <span class="input-group-addon">
                                <i class="gi gi-asterisk"></i>
                            </span>
                        </div>
                        @if($errors->has("japanese"))
                            <span id="example-validation-email-error" class="help-block animation-slideDown">
                                {{ $errors->first("japanese") }}！
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group @if($errors->has("url")) has-error @endif">
                    <label class="col-md-4 control-label" for="example-validation-username">页面URL <span class="text-danger">*</span></label>

                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="example-validation-username" name="url"
                                   class="form-control ui-wizard-content" placeholder="请输入需求页面路由"
                                   required="" aria-required="true" aria-describedby="example-validation-username-error"
                                   aria-invalid="true" value="{{ old('url') ?: $word->url  }}"
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
                            <select id="val-skill" name="person" class="form-control">
                                @foreach( $users as $user )
                                    <option value="{{ $user->id }}"
                                    {{ old("person") ? (old("person") == $user->id ? "selected" : "" ) : ($word->person == $user->id ? "selected" : "" )  }}
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
                            <select id="val-skill" name="sponsor" class="form-control">
                                @foreach( $users as $user )
                                    <option value="{{ $user->id }}"
                                            {{ old("sponsor") ? (old("sponsor") == $user->id ? "selected" : "" ) : ($word->sponsor == $user->id ? "selected" : "" )  }}
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
                        状态
                        <span class="text-danger">&nbsp;&nbsp;</span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select id="val-skill" name="status" class="form-control">
                                    <option value="0" {{ $word->status == 0 ? "selected" : "" }}>正常</option>
                                    <option value="1" {{ $word->status == 1 ? "selected" : "" }}>待处理</option>
                                    <option value="2" {{ $word->status == 2 ? "selected" : "" }}>已处理</option>
                                    <option value="3" {{ $word->status == 3 ? "selected" : "" }}>废弃</option>
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
            <!-- END First Step -->
                <div class="form-group @if($errors->has("description")) has-error @endif">
                    <label class="col-md-4 control-label" for="example-validation-email">
                        详细说明 :
                    </label>
                    <div class="col-md-9"   style="margin: 0 0 0 15%">
                            <textarea id="demo"  name="description" style="display: none;">
                                {{old("description") ?: $word->description }}
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
                        @if($errors->has("description"))
                            <span id="example-validation-email-error" class="help-block animation-slideDown">
                                {{ $errors->first("description") }}！
                            </span>
                        @endif
                    </div>
                </div>
            <!-- Form Buttons -->
            <div class="form-group form-actions">
                <div class="col-md-8 col-md-offset-4">
                    {{--<input type="reset" class="btn btn-sm btn-warning ui-wizard-content ui-formwizard-button" id="back3" value="Back" disabled="disabled">--}}
                    <input type="submit" class="btn btn-sm btn-primary ui-wizard-content ui-formwizard-button" id="next3" value="更新">
                </div>
            </div>
            <!-- END Form Buttons -->
            </div>
        </form>
@stop
