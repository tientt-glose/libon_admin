@extends('index')
@section('title', 'Thêm đơn mượn')

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
<!-- toastr -->
<script src="{{ asset('admin-lte3/plugins/toastr/toastr.min.js') }}"></script>
<!-- custom -->
<script src="{{ asset('js/order.js') }}"></script>

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
    $('#user_check').click(function (){
        var user_code = $('#search_code').val()
        var check_type
        if($('#radio1').is(':checked')) {
            check_type = 0
        }

        if($('#radio2').is(':checked')) {
            check_type = 1
        }

        $.ajax({
            data: {
                user_code: user_code,
                status: check_type,
                csrf: '{{ csrf_field() }}'
            },
            url: '{{ route('user.check') }}',
            type: 'GET',
            success: function (data) {
                if(data.result == 0){
                    $('#user_id').val(null)
                    $('#user_info ul').empty().append('<li>' + data.message + '</li>')
                    toastr.error(data.message)
                }else{
                    $('#user_id').val(data.message.id)
                    $('#user_info ul').empty().append(
                        '<li><b>Mã người dùng: </b>' + data.message.id + '</li>' +
                        '<li><b>Họ & Tên: </b>' + data.message.fullname + '</li>' +
                        '<li><b>Email: </b>' + data.message.email + '</li>' +
                        '<li><b>MSSV/MCB: </b>' + data.message.id_staff_student + '</li>' +
                        '<li><b>CMT/CCCD: </b>' + data.message.id_card + '</li>'
                    )
                    toastr.success('Kiểm tra thành công')
                }
            }
        })
    })

    $('#add_book_button').click(function (){
        var list_barcode = $('#barcode_add').val()
        $.ajax({
            data: {
                list_barcode: list_barcode,
                index: $('#order-table-body tr').length,
                csrf: '{{ csrf_field() }}'
            },
            url: '{{ route('order.orders.addTBook') }}',
            type: 'GET',
            success: function (data) {
                if(data.result == 0){
                    toastr.error(data.message)
                    $('#barcode_add').val('')
                }else{
                    $('#order-table tbody').append(data.html)
                    if (data.errorMess) {
                        toastr.error(data.errorMess)
                    }else{
                        toastr.success('Nhập sách thành công')
                    }
                    $('#barcode_add').val('')
                }
            }
        })
    })

    function deleteRow(_this) {
            $(_this).parent().parent().remove();

            var i = 1;
            $('#order-table-body tr').each(function() {
                $(this).find('td').first().html(i);
                i++;
            });
    }
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
                <h1 class="m-0">Thêm đơn mượn</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('order.orders.index') }}">Danh sách đơn mượn</a></li>
                    <li class="breadcrumb-item active">Thêm đơn mượn</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form action="{{ route('order.orders.store') }}" method="post" id="validateForm">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Phần kiểm tra và nhập thông tin người mượn</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <input type="hidden" name="user_id" id="user_id" />
                                    <div class="form-group">
                                        <label for="search_code">Mã số tìm kiếm:</label>
                                        <input type="number" class="form-control" id="search_code"
                                            placeholder="Nhập vào mã số tương ứng">
                                    </div>
                                    <div class="form-group">
                                        <label>Kiểm tra bằng:</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="radio" id="radio1"
                                                checked>
                                            <label class="form-check-label" for="radio1">Mã số sinh viên, mã cán
                                                bộ</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="radio" id="radio2">
                                            <label class="form-check-label" for="radio2">Số chứng minh thư, căn cước
                                                công
                                                dân</label>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-block" id="user_check"><i
                                            class="fas fa-search"></i>&nbsp;Kiểm tra</button>
                                </div>
                                <div class="col-md-6" id="user_info">
                                    <p> <b>Thông tin người đặt mượn: </b>
                                        <p>
                                            <ul>
                                            </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Phần nhập thông tin sách</h3>
                            <div class="card-tools">
                                <a href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal-add-the-book">
                                    Thêm sách</a>
                            </div>
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="order-table-body">
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
                                            <option value="1">Tự đến lấy</option>
                                            <option value="2">Sử dụng đơn vị vận chuyển</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Địa chỉ nhận sách</label>
                                        <input class="form-control" type="text" id="address" name="address"
                                            placeholder="Không khả dụng" disabled required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="{{ route('order.orders.index') }}" class="btn btn-default float-right">Hủy</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<div id="modal-add-the-book" class="modal fade">
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
                        id="add_book_button">Thêm</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
