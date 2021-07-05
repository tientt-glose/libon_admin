@php
$currentRouteName = \Request::route()->getName();
// dd($currentRouteName)
@endphp
<!-- Main Sidebar Container -->
<!-- Brand Logo -->
<a href="{{ route('home') }}" class="brand-link">
    <img src="{{ asset("img/logo--mini.png") }}" alt="LibOn Logo" class="brand-image">
    <span class="brand-text font-weight-bolder" style="color: #d53d26">LibOn</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu"
            data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
            <li class="nav-item @if(strpos($currentRouteName, 'home') === 0) menu-open @endif">
                <a href="{{ route('home') }}"
                    class="nav-link @if(strpos($currentRouteName, 'home') === 0) active @endif">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            <li class="nav-item @if(strpos($currentRouteName, 'order.') === 0) menu-open @endif">
                <a href="#" class="nav-link @if(strpos($currentRouteName, 'order.') === 0) active @endif">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>
                        Quản lý đơn
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('order.orders.index') }}"
                            class="nav-link @if($currentRouteName == 'order.orders.index') active @endif">
                            <i class="fas fa-minus nav-icon"></i>
                            <p>Quản lý đơn mượn</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item @if(strpos($currentRouteName, 'book.') === 0) menu-open @endif">
                <a href="#" class="nav-link @if(strpos($currentRouteName, 'book.') === 0) active @endif">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        Quản lý sách
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('book.books.index') }}"
                            class="nav-link @if($currentRouteName == 'book.books.index') active @endif">
                            <i class="fas fa-minus nav-icon"></i>
                            <p>Quản lý đầu sách</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('book.categories.index') }}"
                            class="nav-link @if($currentRouteName == 'book.categories.index') active @endif">
                            <i class="fas fa-minus nav-icon"></i>
                            <p>Quản lý thể loại sách</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('book.publishers.index') }}"
                            class="nav-link @if($currentRouteName == 'book.publishers.index') active @endif">
                            <i class="fas fa-minus nav-icon"></i>
                            <p>Quản lý Nhà xuất bản</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('book.comments.index') }}"
                            class="nav-link @if($currentRouteName == 'book.comments.index') active @endif">
                            <i class="fas fa-minus nav-icon"></i>
                            <p>Quản lý bình luận</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item @if(strpos($currentRouteName, 'user.') === 0) menu-open @endif">
                <a href="#" class="nav-link @if(strpos($currentRouteName, 'user.') === 0) active @endif">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Quản lý người dùng
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}"
                            class="nav-link @if($currentRouteName == 'user.index') active @endif">
                            <i class="fas fa-minus nav-icon"></i>
                            <p>Danh sách người dùng</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
