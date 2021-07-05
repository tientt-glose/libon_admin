<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    @if (auth()->user())
    <ul class="navbar-nav ml-auto">
        <!-- Admin Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <div class="media">
                        @php
                        $avatar = Auth::user()->avatar!=null ? '/img/user/'.Auth::user()->avatar :
                        asset('img/ava--default.png')
                        @endphp
                        <img src="{{ $avatar }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                {{ auth()->user()->fullname }}
                            </h3>
                            <p class="text-sm">Admin</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> Gia nhập từ
                                {{ date('m/Y', strtotime(auth()->user()->created_at)) }}</p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer">Đăng xuất</a>
            </div>
        </li>
    </ul>
    @endif
</nav>
