<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->username }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route(App\WebRoute::HOME_INDEX) }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            账号首页
                        </p>
                    </a>
                </li>
                {{-- Admin --}}
                @if (auth()->user()->is_admin)
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                管理页面
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route(App\WebRoute::ADMIN_USER_INDEX) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>用户管理</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                {{-- Team --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            团队管理
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route(App\WebRoute::TEAM_INDEX) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>报单目录</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route(App\WebRoute::TEAM_NET) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>网体结构</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Center --}}
                {{-- @if (auth()->user()->is_admin)
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                业务管理
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route(App\WebRoute::CENTER_REGISTER) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>报单中心</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route(App\WebRoute::CENTER_INDEX) }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>报单列表</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif --}}
                {{-- Fund --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            财务管理
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route(App\WebRoute::FUND_CONVERSION_INDEX) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> 资金转换</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route(App\WebRoute::FUND_TRANSFER_INDEX) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> 资金转账</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route(App\WebRoute::FUND_WITHDRAW_INDEX) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> 奖金提现</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Profile --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            个人设置
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route(App\WebRoute::AUTH_PROFILE) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>个人信息</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route(App\WebRoute::AUTH_BANK) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> 银行信息</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route(App\WebRoute::AUTH_RESET_PASSWORD) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> 修改密码</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route(App\WebRoute::AUTH_PHONE) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p> 手机绑定</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Logout --}}
                <li class="nav-item">
                    <a href="{{ route(App\WebRoute::AUTH_LOGOUT) }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            安全退出
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
