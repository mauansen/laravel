@extends('layouts.admin')
@section('title')
    分类添加
@endsection

@section('content')
    <p></p>
    <form class="form-horizontal" action="{{url('nine/cate_save_do')}}" method="post">
        <div class="form-group">
            @csrf
            <label for="inputEmail3"  class="col-sm-2 control-label">分类名称</label>
            <div class="col-sm-10">
                <input type="text" name="cate_name" class="form-control" id="inputEmail3" placeholder="分类名称">
                <span class="span" style="color:red;">@php echo($errors->first('cate_name')) ;@endphp</span>
            </div>

        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">顶级分类</label>
            <div class="col-sm-10">
            <select class="form-control" name="parent_id">
                <option value="0">0</option>
                @foreach($cate_data as $v)
                    <option value="{{$v->cate_id}}">@php echo str_repeat('--',$v->level-1).$v->cate_name @endphp</option>
                @endforeach
            </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">添加</button>
            </div>
        </div>
    </form>
    <script>
        {{--$('.btn').on('click',function(){--}}
        {{--    var cate_name=$('[name="cate_name"]').val();--}}
        {{--    var flase=true;--}}
        {{--    $.ajax({--}}
        {{--        url:"{{url('nine/only')}}",--}}
        {{--        data:{cate_name:cate_name},--}}
        {{--        dataType:"json",--}}
        {{--        success:function (res) {--}}
        {{--            if(res.ret == 1)--}}
        {{--            {--}}
        {{--                flase=false;--}}
        {{--                $('.span').text(res.msg);--}}
        {{--            }--}}
        {{--        }--}}
        {{--    })--}}
        {{--    if(flase)--}}
        {{--    {--}}
        {{--        event.preventDefault();--}}
        {{--    }--}}

        {{--})--}}
    </script>
@endsection
