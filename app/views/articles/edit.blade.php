@extends('_layouts.default')

@section('main')
    <div class="am-g am-g-fixed">
        <div class="am-u-sm-12">
            <h1>编辑/修改 文章内容</h1>
            <hr/>
            @if ($errors->has())
                <div class="am-alert am-alert-danger" data-am-alert>
                    <p>{{ $errors->first() }}</p>
                </div>
            @endif
            {{ Form::model($article, array('url' => URL::route('article.update', $article->id), 'method' => 'PUT', 'class' => "am-form")) }}
            <div class="am-form-group">
                {{ Form::label('title', '文章标题') }}
                {{ Form::text('title', Input::old('title')) }}
            </div>
            <div class="am-form-group">
                {{ Form::label('content', '文章内容') }}
                {{ Form::textarea('content', Input::old('content'), array('rows' => '20')) }}
                <p class="am-form-help">
                    <button id="preview" type="button" class="am-btn am-btn-xs am-btn-primary"><span class="am-icon-eye"></span>更新预览</button>
                </p>
            </div>
            <div class="am-form-group">
                {{ Form::label('tags', '文章标签') }}
                {{ Form::text('tags', Input::old('tags')) }}
                <p class="am-form-help">文章信息内容</p>
            </div>
            <p><button type="submit" class="am-btn am-btn-success">
                    <span class="am-icon-pencil"></span> Modify</button>
            </p>
            {{ Form::close() }}
        </div>
    </div>

    <div class="am-popup" id="preview-popup">
        <div class="am-popup-inner">
            <div class="am-popup-hd">
                <h4 class="am-popup-title"></h4>
      <span data-am-modal-close
            class="am-close">&times;</span>
            </div>
            <div class="am-popup-bd">
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('#preview').on('click', function() {
                $('.am-popup-title').text($('#title').val());
                $.post('preview', {'content': $('#content').val()}, function(data, status) {
                    $('.am-popup-bd').html(data);
                });
                $('#preview-popup').modal();
            });
        });
    </script>
@stop