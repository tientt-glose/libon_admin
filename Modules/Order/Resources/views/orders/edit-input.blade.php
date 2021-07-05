@extends('index')
@section('title', 'Sửa đơn mượn')

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

<script>
    $('#input_book_button').click(function () {
        var list_barcode = $('#barcode_add').val()
        var book_id = []
        check = list_barcode.split(/\r\n|\n|\r/)
        check = check.filter(Boolean)
        if (check.length > $('#order-table-body tr td:nth-child(4)').length) {
            $('#barcode_add').val('')
            return toastr.error('Số sách nhập vào không được lớn hơn số sách trong đơn');
        }

        $('#order-table-body tr td:nth-child(4)').each(function () {
            book_id.push($(this).text())
        })
        $.ajax({
            data: {
                list_barcode: list_barcode,
                book_id: book_id,
                csrf: '{{ csrf_field() }}'
            },
            url: '{{ route('order.orders.inputTBook') }}',
            type: 'GET',
            success: function (data) {
                if (data.result == 0) {
                    toastr.error(data.message)
                    $('#barcode_add').val('')
                } else {
                    $('#order-table-body tr td:nth-child(4)').each(function () {
                        if (data.message[$(this).text()] != undefined) {
                            $(this).siblings('#right-sib').text(data.message[$(this).text()])
                            $(this).siblings('input#barcode_input').val(data.message[$(this).text()])
                        }
                    })
                    if (data.errorMess) {
                        toastr.error(data.errorMess)
                    } else {
                        toastr.success('Nhập sách thành công')
                    }
                    $('#barcode_add').val('')
                }
            }
        })
    })
</script>

<script>
    var $backupAddress = $('#address').val()
    $('#delivery').change(function() {
        if ($('#delivery option:selected').val() == 2 && document.getElementById('address').hasAttribute('disabled')) {
            $('#address').removeAttr('disabled');
            $('#address').attr('placeholder', 'Nhập địa chỉ nhận sách');
            $('#address').val($backupAddress);
        }

        if ($('#delivery option:selected').val() == 1 && !document.getElementById('address').hasAttribute('disabled')) {
            // $('#address').attr('disabled', true);
            $backupAddress = $('#address').val();
            $('#address').val('');
            $('#address').attr({
                'placeholder': 'Không khả dụng',
                'disabled' : true,
            });
        }
    });
</script>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Sửa đơn mượn (nhập sách)</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('order.orders.index') }}">Danh sách đơn mượn</a></li>
                    <li class="breadcrumb-item active">Sửa đơn mượn</li>
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

            {{-- <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <button type="button" class="btn btn-default float-right">Hủy</button>
                    </div>
                </div>
            </div> --}}
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Trạng thái đơn mượn</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
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
                <form action="{{ route('order.orders.update', $query->id) }}" method="post" id="validateForm">
                    @method('PUT')
                    @csrf
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Phần nhập thông tin sách</h3>
                            <div class="card-tools">
                                <a href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal-input-the-book">
                                    Nhập sách</a>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-2">
                            <input type="hidden" name="barcode[]" id="barcode_validate" />
                            <input type="hidden" name="order_status" id="order_status" value="{{ $query->status }}" />
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
                                    @foreach ($query->booksInOrders as $key => $theBook)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td id="right-sib">
                                            {{ $theBook->theBook != null ? $theBook->theBook->barcode : '' }}</td>
                                        <input type="hidden" name="barcode[{{ $theBook->book->id }}]" id="barcode_input"
                                            value />
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
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Phần sửa thông tin hình thức lấy sách</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Hình thức lấy sách</label>
                                        <select class="form-control" aria-placeholder="Lựa chọn hình thức lấy sách"
                                            id="delivery" name="delivery">
                                            <option value="1" {{ $query->delivery == 1 ? 'selected' : null }}>Tự đến lấy
                                            </option>
                                            <option value="2" {{ $query->delivery == 2 ? 'selected' : null }}>Sử dụng
                                                đơn vị vận chuyển</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Địa chỉ nhận sách</label>
                                        <input class="form-control" type="text" id="address" name="address"
                                            placeholder="{{ $query->delivery == 2 ? 'Nhập địa chỉ nhận sách' : 'Không khả dụng' }}"
                                            value="{{ $query->address }}" {{ $query->delivery == 2 ? '' : 'disabled' }}
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="{{ route('order.orders.destroy', $query->id) }}"
                                class="btn btn-danger float-right ml-2"
                                onclick="return confirm('Bạn có chắc chắn muốn hủy đơn mượn này không?')">Hủy đơn</a>
                            <a href="{{ route('order.orders.edit', $query->id) }}"
                                class="btn btn-default float-right">Hủy nhập</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<div id="modal-input-the-book" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm sách</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="barcode_add">Barcode</label>
                        <textarea class="form-control" rows="8" id="barcode_add" name="barcode"
                            placeholder="Nhập barcode ngăn cách bởi dấu xuống dòng (enter sau khi nhập một barcode)"
                            required></textarea>
                    </div>
                    {{-- <div class="form-group">
                            <label for="barcode_add">Barcode</label>
                            <input type="number" class="form-control" id="barcode_add" name="barcode"
                                placeholder="Nhập vào barcode của sách" required>
                        </div> --}}
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"
                        id="input_book_button">Thêm</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
