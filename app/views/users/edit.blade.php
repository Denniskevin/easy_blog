@extends('layouts.default')

@section('main')
  <div class="am-g am-g-fixed">
    <div class="am-u-lg-6 am-u-md-8">
      <br/>
      @if (Session::has('message'))
        <div class="am-alert am-alert-{{ Session::get('message')['type'] }}" data-am-alert>
          <p>{{ Session::get('message')['content'] }}</p>
        </div>
      @endif
      @if ($errors->has())
        <div class="am-alert am-alert-danger" data-am-alert>
          <p>{{ $errors->first() }}</p>
        </div>
      @endif
      {{ Form::model($user, array('url' => 'user/' . $user->id, 'method' => 'PUT', 'class' => 'am-form')) }}
        {{ Form::label('email', '邮件') }}
        <input id="email" name="email" type="email" readonly="readonly" value="{{ $user->email }}"/>
        <br/>
        {{ Form::label('nickname', '用户名称') }}
        <input id="nickname" name="nickname" type="text" value="{{{ Input::old('nickname', $user->nickname) }}}"/>
        <br/>
        {{ Form::label('old_password', '原密码') }}
        {{ Form::password('old_password') }}
        <br/>
        {{ Form::label('password', '新密码') }}
        {{ Form::password('password') }}
        <br/>
        {{ Form::label('password_confirmation', '密码确认') }}
        {{ Form::password('password_confirmation') }}
        <br/>
        <div class="am-cf">
          {{ Form::submit('更新', array('class' => 'am-btn am-btn-primary am-btn-sm am-fl')) }}
        </div>
      {{ Form::close() }}
      <br/>
    </div>
  </div>
@stop