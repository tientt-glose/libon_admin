@extends('layouts.login_index')
@section('title', 'Đăng nhập')

@section('before-theme-styles-end')
<!-- toastr -->
<link rel="stylesheet" href="{{ asset('admin-lte3/plugins/toastr/toastr.min.css') }}">
@endsection

{{-- @section ('before-styles-end')
<!-- custom -->
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection --}}

@section('scripts')
<!-- toastr -->
<script src="{{ asset('admin-lte3/plugins/toastr/toastr.min.js') }}"></script>

@if($errors->any())
@foreach ($errors->all() as $error)
<script>
    toastr.error('{{ $error }}')
</script>
@endforeach
@endif

@if (session()->has('success'))
<script>
    toastr.success('{{ session()->get('success') }}')
</script>
@endif
@endsection

@section('content')
<div class="login-logo">
    <img src="{{ asset("img/logo.png") }}" alt="LibOn Logo" class="login-image">
</div>

{{-- <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
    @if ($errors->any())
    @foreach($errors->all() as $error)
        {{ $error }} <br>
@endforeach
@endif
</div> --}}

<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Đăng nhập để bắt đầu phiên làm việc</p>
        <form method="post" action="{{ route('login') }}">
            @csrf
            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-7">
                    <div class="icheck-primary">
                        <input type="checkbox" name="remember_me" id="remember_me" value="true">
                        <label for="remember_me">
                            Ghi nhớ mật khẩu
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-5">
                    <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        {{--<a href="{{route('forgot_password')}}">@lang('core::general.forgot_password')</a><br>--}}

    </div>
</div>
@endsection
