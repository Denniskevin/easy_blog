<button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-secondary am-show-sm-only"
        data-am-collapse="{target: '#collapse-head'}"><span class="am-sr-only">nav switch</span>
        <span class="am-icon-bars"></span></button>
<div class="am-collapse am-topbar-collapse" id="collapse-head">
  @if (Auth::check())
    @if (Auth::user()->is_admin)
    <ul class="am-nav am-nav-pills am-topbar-nav">
      <li class="{{ (isset($page) and ($page == 'users')) ? 'am-active' : '' }}"><a href="{{ URL::to('admin/users') }}"></a></li>
      <li class="{{ (isset($page) and ($page == 'articles')) ? 'am-active' : '' }}"><a href="{{ URL::to('admin/articles') }}">文章</a></li>
      <li class="{{ (isset($page) and ($page == 'tags')) ? 'am-active' : '' }}"><a href="{{ URL::to('admin/tags') }}">标签</a></li>
    </ul>
    @endif
    <div class="am-topbar-right">
      <div class="am-dropdown" data-am-dropdown="{boundary: '.am-topbar'}">
        <button class="am-btn am-btn-secondary am-topbar-btn am-btn-sm am-dropdown-toggle" data-am-dropdown-toggle><span class="am-icon-users"></span> {{{ Auth::user()->nickname }}} <span class="am-icon-caret-down"></span></button>
        <ul class="am-dropdown-content">
          <li><a href="{{ URL::to('article/create') }}"><span class="am-icon-edit"></span>发布文章</a></li>
          <li><a href="{{ URL::to('user/'. Auth::id() . '/edit') }}"><span class="am-icon-user"></span>用户设置</a></li>
          <li><a href="{{ URL::to('logout') }}"><span class="am-icon-power-off"></span>退出</a></li>
        </ul>
      </div>
    </div>
    <div class="am-topbar-right">
      <a href="{{ URL::to('user/'. Auth::id() . '/articles') }}" class="am-btn am-btn-primary am-topbar-btn am-btn-sm topbar-link-btn"><span class="am-icon-list"></span>文章管理</a>
    </div>
  @else
    <div class="am-topbar-right">
      <a href="{{ URL::to('register') }}" class="am-btn am-btn-secondary am-topbar-btn am-btn-sm topbar-link-btn"><span class="am-icon-pencil"></span>注册</a>
    </div>
    <div class="am-topbar-right">
      <a href="{{ URL::to('login') }}" class="am-btn am-btn-primary am-topbar-btn am-btn-sm topbar-link-btn"><span class="am-icon-user"></span>登录</a>
    </div>
  @endif
</div>