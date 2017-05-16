<html>
<head>
    <title>您有新的待办事件</title>
    <style>
        *{
            margin: 0 auto;
            padding: 0;
        }
        body{
            /*background: wheat;*/
        }
        body>header{
            width: 96%;
            text-align: center;
        }
        body>section>header{
            width:100% ;
            text-align: center;
            height: 40px;
            font-size: 20px;
            line-height: 40px;
        }
        body>header>img{
            border-radius:50%; overflow:hidden;
        }
        table{
            width: 96%;
            /*border: 1px solid #357ca5;*/
            text-align: center;
        }
        tr{
            height: 40px;
        }
        td,th{
            border-bottom: 1px dashed #245580;
        }
        footer{
            height: 100px;
            padding-top: 20px;
            text-align: center;
        }
        footer a{
            text-decoration: double;
            color: black;
            -webkit-appearance: button;
            cursor: pointer;
            background-color: #de4b39;
            border-color: #de4b39;
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
            background-image: none;
            white-space: nowrap;
            touch-action: manipulation;
            font-weight: normal;
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <header style="width: 96%;
            text-align: center;">
        <img style="border-radius:50%; overflow:hidden;" width="100" height="100" src="{{ url(url("img/user/".$user->head)) }}" alt="">
    </header>
    <section>
        <header style="width:100% ;
            text-align: center;
            height: 40px;
            font-size: 20px;
            line-height: 40px;">
            你好,{{$user->name}},在COOL翻译管理系统中有需要您去完成的翻译事件。
        </header>
        {{--<table>--}}
            {{--<tr>--}}
                {{--<th>发起人</th>--}}
                {{--<th>词汇/需求</th>--}}
                {{--<th>时间</th>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td>发起人</td>--}}
                {{--<td>词汇/需求</td>--}}
                {{--<td>时间</td>--}}
            {{--</tr>--}}
        {{--</table>--}}
    </section>
    <footer style="height: 100px;
            padding-top: 20px;
            text-align: center;">
        <a href="{{ url('/word?person='.$user->id) }}" style=" text-decoration: double;
            color: black;
            -webkit-appearance: button;
            cursor: pointer;
            background-color: #de4b39;
            border-color: #de4b39;
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
            background-image: none;
            white-space: nowrap;
            touch-action: manipulation;
            font-weight: normal;
            text-align: center;
            vertical-align: middle;">点击此处直接前往处理</a>
    </footer>
</body>
</html>