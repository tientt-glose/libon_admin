@extends('index')
@section('title', 'Thêm người dùng')

@section('before-adminLTE-styles-end')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin-lte3/plugins/select2/css/select2.min.css') }}">
<!-- toastr -->
<link rel="stylesheet" href="{{ asset('admin-lte3/plugins/toastr/toastr.min.css') }}">
@endsection

@section ('before-styles-end')
<!-- custom -->
<link rel="stylesheet" href="{{ asset('css/book.css') }}">
@endsection

@section('script')
<!-- Select2 -->
<script src="{{ asset('admin-lte3/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('admin-lte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin-lte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
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
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Thêm người dùng</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Danh sách người dùng</a></li>
                    <li class="breadcrumb-item active">Thêm người dùng</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data" id="validateForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Phần nhập thông tin người dùng</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fullname">Họ tên</label>
                                        <input type="text" class="form-control" id="fullname" name="fullname" value=""
                                            placeholder="Nhập vào tên người dùng">
                                    </div>
                                    <div class="form-group">
                                        <label for="id_card">Số CMT/CCCD</label>
                                        <input type="number" class="form-control" id="id_card" name="id_card" value=""
                                            placeholder="Nhập vào số chứng minh thư, căn cước công dân">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Địa chỉ email</label>
                                        <input type="email" class="form-control" id="email" name="email" value=""
                                            placeholder="Nhập vào email">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Mật khẩu</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Nhập vào mật khẩu mới">
                                    </div>
                                    <div class="form-group">
                                        <label for="dob">Ngày sinh</label>
                                        <input type="date" class="form-control" id="dob" name="dob" value=""
                                            placeholder="Nhập vào ngày sinh">
                                    </div>
                                    <div class="form-group">
                                        <label for="career">Nghề nghiệp</label>
                                        <select class="form-control" id="career" name="career"
                                            data-placeholder="Chọn nghề nghiệp" style="width: 100%;">
                                            <option value="1">Sinh viên</option>
                                            <option value="2">Giáo viên</option>
                                            <option value="3">Chuyên viên</option>
                                            <option value="4">Khác</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="gender-select">
                                        <label for="gender">Giới tính</label>
                                        <select class="form-control selectGender" id="gender" name="gender"
                                            data-placeholder="Chọn giới tính" style="width: 100%;">
                                            <option value="0">Nam</option>
                                            <option value="1">Nữ</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Số điện thoại</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" value=""
                                            placeholder="Nhập vào số điện thoại">
                                    </div>
                                    <div class="form-group">
                                        <label for="organization">Cơ quan</label>
                                        <select class="form-control" id="organization" name="organization_id"
                                            data-placeholder="Chọn cơ quan" style="width: 100%;">
                                            @foreach ($organization as $organizationItem)
                                            <option value="{{$organizationItem->id}}">{{$organizationItem->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_staff_student">Mã thẻ sinh viên/mã cán bộ</label>
                                        <input type="number" class="form-control" id="id_staff_student"
                                            name="id_staff_student" value=""
                                            placeholder="Nhập vào mã số vinh viên, mã cán bộ">
                                    </div>
                                    <div class="form-group">
                                        <label for="admin">Là Admin</label>
                                        <select class="form-control" id="admin" name="admin"
                                            data-placeholder="Chọn loại người dùng" style="width: 100%;">
                                            <option value="0">Người dùng</option>
                                            <option value="1">Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="{{ route('user.index') }}" class="btn btn-default float-right">Hủy</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
