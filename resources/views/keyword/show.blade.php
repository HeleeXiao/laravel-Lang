@extends("layouts.manager")

@section("title","词汇详情 - ".config('app.name'))
@section("content")
        <form id="validation-wizard" action="{{ url('word/'.$id) }}" method="post"
              class="form-horizontal form-bordered ui-formwizard" novalidate="novalidate">
            <div id="validation-first" class="step ui-formwizard-content" style="display: block;">

                <!-- Step Info -->
                <div class="form-group">
                    <div class="col-xs-12">
                        <ul class="nav nav-pills nav-justified">
                            <li class="active disabled">
                                <a href="javascript:void(0)" class="text-muted">
                                    {{--<i class="fa fa-user"></i>--}}
                                    <i class="fa fa-info-circle"></i>
                                    <strong>词汇详情</strong>
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
                <div class="form-group @if($errors->has("japanese")) has-error @endif">
                    <label class="col-md-4 control-label" for="example-validation-email">
                        详细说明 :
                    </label>
                    <div class="col-md-9"   style="margin: 0 0 0 15%;padding:5px;border-bottom:1px solid black;
                border-top:1px solid black">
                        <style>
                            img{width:100%}
                        </style>
                        {!! $word->description !!}
                    </div>
                </div>
                <div class="form-group @if($errors->has("var_name")) has-error @endif">
                    <label class="col-md-4 control-label" for="example-validation-username">变量名 <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="example-validation-username" name="var_name"
                                   class="form-control ui-wizard-content" placeholder="请输入权限名称"
                                   required="" aria-required="true" aria-describedby="example-validation-username-error"
                                   aria-invalid="true" value="{{ old('var_name') ?: $word->var_name }}" disabled
                            >
                            <span class="input-group-addon">
                                <i class="gi gi-asterisk"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group @if($errors->has("chinese")) has-error @endif">
                    <label class="col-md-4 control-label" for="example-validation-password">
                        中文词汇
                    </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="example-validation-password" name="chinese"
                                   class="form-control ui-wizard-content" placeholder="请输入中文词汇"
                                   required="" value="{{ old('chinese') ?: $word->chinese  }}"
                                   aria-required="true" aria-describedby="example-validation-password-error"
                                   aria-invalid="true" disabled>
                            <span class="input-group-addon">
                                <i class="gi gi-asterisk"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group @if($errors->has("japanese")) has-error @endif">
                    <label class="col-md-4 control-label" for="example-validation-email">
                        日文词汇
                    </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="example-validation-email" name="japanese"
                                   class="form-control ui-wizard-content" placeholder="请输入日文词汇"
                                   required="" aria-required="true" aria-describedby="example-validation-email-error"
                                   aria-invalid="true" value="{{ old('japanese') ?: $word->japanese  }}" disabled>
                            <span class="input-group-addon">
                                <i class="gi gi-asterisk"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="example-validation-confirm-password">
                        责任人
                    </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select id="val-skill" name="person" class="form-control" disabled>
                                    <option value="" >{{ $word->personUser->name }}</option>
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
                    </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select id="val-skill" name="sponsor" class="form-control" disabled>
                                    <option value="">{{ $word->sponsorUser->name }}</option>
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
                            <select id="val-skill" name="status" class="form-control" disabled>
                                    <option value="0" {{ $word->status == 0 ? "selected" : "" }}>正常</option>
                                    <option value="1" {{ $word->status == 1 ? "selected" : "" }}>待处理</option>
                                    <option value="2" {{ $word->status == 2 ? "selected" : "" }}>已处理</option>
                                    <option value="3" {{ $word->status == 3 ? "selected" : "" }}>废弃</option>
                            </select>
                            <span class="input-group-addon">
                                <i class="gi gi-asterisk"></i>
                            </span>
                        </div>
                </div>
            </div>
                <!-- END First Step -->

            </div>
        </form>
@stop
