@extends("layouts.manager")

@section("title","词汇需求列表 - ".config('app.name'))

@section("content")
    <?php
    $label_class = [
            "",'label label-info','label label-primary','label label-success','label label-warning'
    ];
    $label_class_status = [
            'label label-info','label label-primary','label label-success','label label-warning'
    ];
    ?>
    <!-- 首页内容下方 -->

        <div class="block-title">
            <h2>词汇需求列表</h2>
            <i class="fi fi-php"></i>
        </div>
        <div class="table-responsive">
            <div id="example-datatable_wrapper" class="dataTables_wrapper form-inline no-footer">
                <div class="row">
                    <div class="col-sm-6 col-xs-5">
                        <div class="dataTables_length" id="example-datatable_length">
                            <label>
                                <select name="example-datatable_length" aria-controls="example-datatable"
                                        onchange="
                                                var queryString = '{{ $request->getQueryString() }}',
                                                limit = $(this).val(),
                                                url = '{{ $request->url() }}';
                                                window.location.href=url + ( queryString ? '?'+queryString+'&l='+limit : '?l='+limit )"
                                        class="form-control">
                                    <option value="5"
                                            @if(request('l') == 5)
                                                selected
                                            @endif
                                            >
                                        5
                                    </option>
                                    <option value="10"
                                            @if(request()->has('l') && request('l') == 10)
                                                selected
                                            @elseif( ( ! request()->has('l') || !in_array(request('l'),[5,10,20]) ) && config('list.limit',10) == 10)
                                                selected
                                            @endif
                                            >
                                        10
                                    </option>
                                    <option value="20"
                                            @if(request('l') == 20)
                                                selected
                                            @endif
                                            >
                                        20
                                    </option>
                                </select>
                            </label>
                        </div>
                    </div>
                    @include('layouts.manager-search')
                </div>
                <table id="example-datatable" class="table table-striped table-bordered table-vcenter dataTable no-footer"
                       role="grid" aria-describedby="example-datatable_info">
                    <thead>
                    <tr role="row">
                        <th  >ID</th>

                        <th >标题</th>
                        <th >URL</th>
                        <th >词汇量</th>
                        <th style="width: 8%" >责任人</th>
                        <th style="width: 8%" >发起人</th>
                        <th style="width: 6%" >状态</th>
                        <th style="width: 12%">更新时间</th>
                        <th class="text-center sorting_disabled" style="width: 12%" rowspan="1" colspan="1" aria-label="">
                            <i class="fa fa-flash"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $info)
                        <tr role="row" class="odd">
                            <td class="text-center sorting_1" id="update-id-{{ $info->id }}">{{ $info->id }}</td>

                            <td><strong>{{ $info->title }}</strong></td>
                            <td><a href="{{ $info->url }}">{{ $info->url }}</a></td>
                            <td>{{ count($info->keyWords) }}</td>
                            <td align="center">
                                <a href="{{ $request->url().($request->getQueryString()? '?'.$request->getQueryString().'&person='.$info->person:'?person='.$info->person ) }}">
                                    <span class="{{ $label_class[$info->person] }}">{{ $info->personUser->name }}</span>
                                </a>
                            </td>
                            <td align="center">
                                <a target="_blank" href="{{ $request->url().($request->getQueryString()? '?'.$request->getQueryString().'&sponsor='.$info->sponsor:'?sponsor='.$info->sponsor ) }}">
                                    <span class="{{ $label_class[$info->sponsor] }}">{{ $info->sponsorUser->name }}</span>
                                </a>
                            </td>
                            <td align="center">
                                <span class="{{ $label_class_status[$info->status] }}">{{ config("app.status")[$info->status] }}</span>
                            </td>
                            <td align="center" id="update-timer-{{ $info->id }}">
                                @if($info->comment)
                                    <abbr title=" " style="color: #e53e49"
                                          onmouseout="layer.closeAll();"
                                          onmouseover="layer.closeAll();
                                                  layer.tips(
                                                      '{{ $info->comment }}',
                                                      $(this),
                                                      {
                                                          tips:  [4, '#e53e49'],
                                                          tipsMore: true, time: 10000
                                                      }
                                                  );">
                                        {{ \Carbon\Carbon::parse($info->updated_at)->format("m月d日 H:i") }}
                                    </abbr>
                                @else
                                {{ \Carbon\Carbon::parse($info->updated_at)->format("m月d日 H:i") }}
                                @endif
                            </td>
                            @if($info->comment && $info->person == Auth::id())
                                <script>
                                    layer.tips("{{ $info->comment }}", $("#update-id-{{ $info->id }}"), {tips:  [4, '#e53e49'], tipsMore: true, time: 500000});
                                </script>
                            @endif
                            <td class="text-center">
                                    <a href="{{ url("lang/$info->id") }}" data-toggle="tooltip" title=""
                                       class="btn btn-effect-ripple btn-xs btn-info" style="overflow: hidden; position: relative;"
                                       data-original-title="预览" >
                                        <i class="gi gi-eye_open"></i>
                                    </a>
                                    @if($info->status == 1)
                                        {{--<a href="{{ url("lang/solve/$info->id") }}" data-toggle="tooltip" title=""--}}
                                           {{--class="btn btn-effect-ripple btn-xs btn-success" style="overflow: hidden; position: relative;"--}}
                                           {{--data-original-title="解决" >--}}
                                            {{--<i class="gi gi-ok_2"></i>--}}
                                        {{--</a>--}}
                                    @endif
                                    <a href="{{ url("lang/$info->id/edit") }}" data-toggle="tooltip" title=""
                                       class="btn btn-effect-ripple btn-xs btn-danger" style="overflow: hidden; position: relative;"
                                       data-original-title="编辑" >
                                            <i class="fa fa-pencil"></i>
                                    </a>

                                    {{--<form style="display:inline-block" action="javascript:;" method="post" id="destroy-{{ $info->id }}">--}}
                                    {{--{{ csrf_field() }}--}}
                                    {{--<input type="hidden" name="_method" value="delete">--}}
                                    {{--<a href="javascript:void(0)" data-toggle="tooltip" title=""--}}
                                       {{--class="btn btn-effect-ripple btn-xs btn-primary" style="overflow: hidden; position: relative;"--}}
                                       {{--data-original-title="删除"--}}
                                       {{--onclick="layer.confirm('{{ trans('messages.entrust_delete_alert') }}',{--}}
                                               {{--btn:['No', 'Yes'],--}}
                                               {{--title:'警告',--}}
                                               {{--icon:0--}}
                                               {{--},function(index, layero){--}}
                                                    {{--layer.closeAll()--}}
                                               {{--}--}}
                                               {{--,function(index, layero){--}}
                                                    {{--$('#destroy-{{ $info->id }}').submit()--}}
                                               {{--}); return false;">--}}
                                            {{--<i class="fa fa-times" ></i>--}}
                                    {{--</a>--}}
                                {{--</form>--}}

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-sm-5 hidden-xs">
                        <div class="dataTables_info" id="example-datatable_info" role="status" aria-live="polite">
                            <strong>{{ $list->perPage() * ($list->currentPage()-1) + 1 }}</strong>-
                            <strong>{{ $list->currentPage() == $list->lastPage() ? $list->total() :
                            $list->perPage() * $list->currentPage() }}</strong> of
                            <strong>{{ $list->total() }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-7 col-xs-12 clearfix">
                        <div class="dataTables_paginate paging_bootstrap" id="example-datatable_paginate">
                            {!! $list->appends([
                                'l'=>request('l')?:config('project.list.limit'),
                                'keywords'  => request('keywords')
                            ])->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

@stop