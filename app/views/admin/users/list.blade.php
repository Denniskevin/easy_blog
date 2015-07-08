@extends('_layouts.default')

@section('main')
<div class="am-g am-g-fixed">
  <div class="am-u-sm-12">
  	<br/>
  	@if (Session::has('message'))
	<div class="am-alert am-alert-{{ Session::get('message')['type'] }}" data-am-alert>
	  <p>{{ Session::get('message')['content'] }}</p>
	</div>
	@endif
  	<table class="am-table am-table-hover am-table-striped ">
	  <thead>
	  <tr>
	    <th>用户ID</th>
	    <th>邮箱</th>
	    <th>用户名</th>
	    <th>用户管理</th>
	  </tr>
	  </thead>
	  <tbody>
	  @foreach ($users as $user)
		<tr>
	  	<td>{{ $user->id }}</td>
	  	<td>{{ $user->email }}</td>
	  	{{--<td>{{{ $user->nickname }}}</td>--}}
            <a href="{{ URL::to('user/' . $user->id . '/articles') }}">{{{ $user->nickname }}}</a>
	    <td>
		  <a href="{{ URL::to('user/'. $user->id . '/edit') }}" class="am-btn am-btn-xs am-btn-primary">用户更新</a>
		  {{ Form::open(array('url' => 'user/' . $user->id . '/reset', 'method' => 'PUT', 'style' => 'display: inline;')) }}
		  	<button type="button" class="am-btn am-btn-xs am-btn-warning" id="reset{{ $user->id }}">恢复</button>
		  {{ Form::close() }}
		  @if ($user->block)
	      {{ Form::open(array('url' => 'user/' . $user->id . '/unblock', 'method' => 'PUT', 'style' => 'display: inline;')) }}
		  	<button type="button" class="am-btn am-btn-xs am-btn-danger" id="unblock{{ $user->id }}">用户解锁</button>
		  {{ Form::close() }}
		  @else
		  {{ Form::open(array('url' => 'user/' . $user->id, 'method' => 'DELETE', 'style' => 'display: inline;')) }}
		  	<button type="button" class="am-btn am-btn-xs am-btn-danger" id="delete{{ $user->id }}">用户锁定</button>
		  {{ Form::close() }}
		  @endif
	    </td>
	  </tr>
	  @endforeach
	  </tbody>
	</table>
  </div>
</div>

<div class="am-modal am-modal-confirm" tabindex="-1" id="my-confirm">
  <div class="am-modal-dialog">
    <div class="am-modal-bd">
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn" data-am-modal-cancel>No</span>
      <span class="am-modal-btn" data-am-modal-confirm>Yes</span>
    </div>
  </div>
</div>
<script>
  $(function() {
    $('[id^=reset]').on('click', function() {
      $('.am-modal-bd').text('密码变更为123456');
      $('#my-confirm').modal({
        relatedTarget: this,
        onConfirm: function(options) {
          $(this.relatedTarget).parent().submit();
        },
        onCancel: function() {
        }
      });
    });

    $('[id^=delete]').on('click', function() {
      $('.am-modal-bd').text('锁定用户？');
      $('#my-confirm').modal({
        relatedTarget: this,
        onConfirm: function(options) {
          $(this.relatedTarget).parent().submit();
        },
        onCancel: function() {
        }
      });
    });

    $('[id^=unblock]').on('click', function() {
      $('.am-modal-bd').text('解锁用户?');
      $('#my-confirm').modal({
        relatedTarget: this,
        onConfirm: function(options) {
          $(this.relatedTarget).parent().submit();
        },
        onCancel: function() {
        }
      });
    });
  });
</script>
@stop