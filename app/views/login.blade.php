@extends('_layouts.default')

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
      {{ Form::open(array('url' => 'login', 'class' => 'am-form')) }}
        {{ Form::label('email', '邮箱') }}
        {{ Form::email('email', Input::old('email')) }}
        <br/>
        {{ Form::label('password', '密码') }}
        {{ Form::password('password') }}
        <br/>
        <label for="remember_me">
          <input id="remember_me" name="remember_me" type="checkbox" value="1">
          记住密码
        </label>
        <br/>
        <div class="am-cf">
          {{ Form::submit('登录', array('class' => 'am-btn am-btn-primary am-btn-sm am-fl')) }}
        </div>
      {{ Form::close() }}
      <br/>
    </div>
  </div>
@stop