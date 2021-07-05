@extends('index')
@section('title', 'Chi tiết đơn mượn')

@section('before-adminLTE-styles-end')
<!-- toastr -->
<link rel="stylesheet" href="{{ asset('admin-lte3/plugins/toastr/toastr.min.css') }}">
@endsection

@section ('before-styles-end')
<!-- custom -->
<link rel="stylesheet" href="{{ asset('css/order.css') }}">
@endsection

@section('script')
<!-- jquery-validation -->
<script src="{{ asset('admin-lte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin-lte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- moment -->
<script src="{{ asset('admin-lte3/plugins/moment/moment.min.js') }}"></script>
<!-- toastr -->
<script src="{{ asset('admin-lte3/plugins/toastr/toastr.min.js') }}"></script>
<!-- custom -->
<script src="{{ asset('js/order-edit.js') }}"></script>

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
                <h1 class="m-0">Chi tiết đơn mượn</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('order.orders.index') }}">Danh sách đơn mượn</a></li>
                    <li class="breadcrumb-item active">Chi tiết đơn mượn</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Phần thông tin người đặt mượn</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <ul class="m-0">
                            <li><b>Mã người dùng: </b>{{ $query->user->id }}</li>
                            <li><b>Họ & Tên: </b>{{ $query->user->fullname }}</li>
                            <li><b>Email: </b>{{ $query->user->email }}</li>
                            <li><b>MSSV/MCB: </b>{{ $query->user->id_staff_student }}</li>
                            <li><b>CMT/CCCD: </b>{{ $query->user->id_card }}</li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Phần thông tin đơn đặt mượn</h3>
                    </div>
                    <div class="card-body">
                        <ul class="m-0">
                            <li><b>Mã đơn: </b>{{ $query->id }}</li>
                            <li><b>Hạn trả:</b>
                                <span id="deadline">
                                    {{ $query->restore_deadline != null ? date('d-m-Y', strtotime($query->restore_deadline)) : '' }}
                                </span>
                            </li>
                            <li><b>Ngày tạo:</b>
                                <span id="created">
                                    {{ $query->created_at != null ? date('d-m-Y H:i', strtotime($query->created_at)) : ''}}
                                </span>
                            </li>
                            <li><b>Ngày đến lấy:</b>
                                <span id="pick">
                                    {{ $query->pick_time != null ? date('d-m-Y H:i', strtotime($query->pick_time)) : ''}}
                                </span>
                            </li>
                            <li><b>Ngày trả:</b>
                                <span id="restore">
                                    {{ $query->restore_time != null ? date('d-m-Y H:i', strtotime($query->restore_time)) : '' }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Phần thông tin hình thức lấy sách</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hình thức lấy sách</label>
                                    <select class="form-control" disabled>
                                        <option value="1" {{ $query->delivery == 1 ? 'selected' : null }}>Tự đến lấy
                                        </option>
                                        <option value="2" {{ $query->delivery == 2 ? 'selected' : null }}>Sử dụng đơn vị
                                            vận chuyển</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Địa chỉ nhận sách</label>
                                    <input class="form-control" type="text" placeholder="Không khả dụng"
                                        value="{{ $query->address }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Trạng thái đơn mượn</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <input type="hidden" name="order_status" id="order_status" value="{{ $query->status }}" />
                        <div class="row" id="progress-bar">
                            <div class="col-md-2 offset-1 status">
                                <div class="circle ml-4">
                                    <i class="fa fa-check"></i>
                                    <i class="fa fa-close"></i>
                                    <i class="fa fa-sync-alt fa-spin"></i></div>
                                <div class="line ml-4"></div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar">
                                        Tạo thành công
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 status" id="second-child">
                                <div class="circle ml-3">
                                    <i class="fa fa-check"></i>
                                    <i class="fa fa-close"></i>
                                    <i class="fa fa-sync-alt fa-spin"></i></div>
                                <div class="line ml-4"></div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar">
                                        Đang mượn
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-2 status">
                                <div class="circle ml-4">
                                    <i class="fa fa-check"></i>
                                    <i class="fa fa-close"></i>
                                    <i class="fa fa-sync-alt fa-spin"></i></div>
                                <div class="line ml-4"></div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar">
                                        Sắp tới hạn trả
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 status">
                                <div class="circle ml-2">
                                    <i class="fa fa-check"></i>
                                    <i class="fa fa-close"></i>
                                    <i class="fa fa-sync-alt fa-spin"></i></div>
                                <div class="line ml-3"></div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar">
                                        Quá hạn
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-2 status">
                                <div class="circle ml-3">
                                    <i class="fa fa-check"></i>
                                    <i class="fa fa-close"></i>
                                    <i class="fa fa-sync-alt fa-spin"></i></div>
                                {{-- <div class="line"></div> --}}
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar">
                                        Đã trả sách
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Phần thông tin sách</h3>
                    </div>
                    <div class="card-body table-responsive p-2">
                        <table class="table table-hover text-nowrap table-bordered projects" id="order-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mã đầu sách</th>
                                    <th>Mã sách</th>
                                    <th>Ảnh bìa</th>
                                    <th>Tên sách</th>
                                    <th>Tác giả</th>
                                </tr>
                            </thead>
                            <tbody id="order-table-body">
                                @foreach ($query->booksInOrdersTrashed as $key => $theBook)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td id="right-sib">
                                        <del>{{ $theBook->theBook != null ? $theBook->theBook->barcode : '' }}</del>
                                    </td>
                                    <td>{{ $theBook->book->id }}</td>
                                    <td><img class="image-book" src="{{ $theBook->book->pic_link }}"></td>
                                    <td>{{ $theBook->book->name }}</td>
                                    <td>{{ $theBook->book->author }}</td>
                                </tr>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('order.orders.index') }}" class="btn btn-default float-right">Trở về</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
