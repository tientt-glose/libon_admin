@extends('index')
@section('title', 'Quản lý đơn mượn')

@section('before-adminLTE-styles-end')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin-lte3/plugins/select2/css/select2.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('admin-lte3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin-lte3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('admin-lte3/plugins/daterangepicker/daterangepicker.css') }}">
<!-- toastr -->
<link rel="stylesheet" href="{{ asset('admin-lte3/plugins/toastr/toastr.min.css') }}">
@endsection

@section ('before-styles-end')
<!-- custom -->
<link rel="stylesheet" href="{{ asset('css/order.css') }}">
@endsection

@section('script')
<!-- Select2 -->
<script src="{{ asset('admin-lte3/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('admin-lte3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin-lte3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin-lte3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin-lte3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- moment -->
<script src="{{ asset('admin-lte3/plugins/moment/moment.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('admin-lte3/plugins/daterangepicker/daterangepicker.js') }}"></script>
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

<script>
    $(document).ready(function() {
    //Initialize Select2 Elements
        $('.select2').select2({
            width: 'resolve',
            allowClear: true
            // dropdownParent: $('#category-select')
        })
    });
</script>

<script>
    $(function() {
        table = $('#table-order').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            searching: false,
            responsive: true,
            ajax: {
                url: '{{ route("order.orders.get") }}',
                type: 'get',
                data: function(d) {
                    d.status = $('#status option:selected').val();
                    d.created_at = $('#reservationtime').val()
                    d.user_name = $('#user_name').val();
                    d.order_id = $('#order_id').val();
                    d.card = $('#card').val();
                    d.code = $('#code').val();
                    d.csrf = '{{ csrf_field() }}';
                }
            },
            columns: [
                {data: 'id', sortable: true},
                {data: 'user_name', sortable: true},
                {data: 'user_card', orderable: false},
                {data: 'user_code', orderable: false},
                {data: 'status', orderable: false},
                {data: 'restore_deadline', orderable: false},
                {data: 'created_at', orderable: false},
                {data: 'pick_time', orderable: false},
                {data: 'restore_time', sortable: true},
                {data: 'actions', orderable: false},
            ],
            order: [[0, 'desc' ]],
            language: {
                lengthMenu: 'Hiển thị _MENU_ bản ghi trên một trang',
                zeroRecords: 'Không tìm thấy bản ghi phù hợp',
                infoEmpty: 'Không có dữ liệu',
                infoFiltered: '(lọc từ tổng số _MAX_ bản ghi)',
                info: 'Hiển thị từ _START_ đến _END_ trong tổng số _TOTAL_ kết quả',
                search: 'Tìm kiếm:',
                paginate: {
                    previous:   '«',
                    next:       '»'
                },
                processing: '<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading'
            },
            columnDefs: [
            ]
        });
    });

    function filter(){
        table.draw()
        // console.log(1)
    }

    $('#reset_button').click(function (params) {
        $('#filter input').val('')
        $('.select2').val(null).trigger('change');
        filter()
    })

    $('#search_button').click(function (params) {
        filter()
    })

    $('#reservationtime').daterangepicker({
        showDropdowns: true,
        timePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 1,
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY HH:mm',
            cancelLabel: 'Xóa',
            applyLabel: 'Áp dụng'
        }
    })

    $('input[name="created_at"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY HH:mm') + ' - ' + picker.endDate.format('DD/MM/YYYY HH:mm'))
      filter()
    });

    $('input[name="created_at"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('')
      filter()
    });
</script>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý đơn mượn</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Danh sách đơn mượn</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Lọc đơn mượn</h3>
        </div>
        <div class="card-body p-2" id="filter">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Trạng thái đơn mượn:</label>
                        <select class="form-control filter-status select2" style="width: 100%;" name="status"
                            id="status" data-placeholder="Tất cả trạng thái" onchange="filter()">
                            <option value="-1">Tất cả trạng thái</option>
                            @foreach($listStatus as $key => $status)
                            <option value="{{ $key }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Ngày tạo:</label>
                        <div class="input-group">
                            <input type="text" class="form-control float-left" id="reservationtime" name="created_at"
                                value="" placeholder="Ngày tạo">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                            </div>
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="user_name">Tên người mượn:</label>
                        <input type="text" class="form-control" id="user_name" name="user_name"
                            placeholder="Tên người mượn" onchange="filter()">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="user_name">Mã đơn:</label>
                        <input type="number" class="form-control" id="order_id" name="order_id" placeholder="Mã đơn"
                            onchange="filter()">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="user_name">CMT/CCCD:</label>
                        <input type="text" class="form-control" id="card" name="card"
                            placeholder="Chứng minh thư, Căn cước công dân" onchange="filter()">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="user_name">MSSV/MCB:</label>
                        <input type="text" class="form-control" id="code" name="code"
                            placeholder="Mã số sinh viên, mã cán bộ" onchange="filter()">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Action:</label>
                        <button type="button" class="btn btn-primary btn-block form-control" id="search_button"><i
                                class="fas fa-search"></i>&nbsp;Tìm kiếm</button>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label style="visibility: hidden">A</label>
                        <button type="button" class="btn btn-default btn-block form-control" id="reset_button"><i
                                class="fas fa-times"></i>&nbsp;Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <a href="{{ route('order.orders.create') }}" class="btn btn-primary float-right">
                Thêm đơn mượn</a>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover projects" id="table-order">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Người mượn</th>
                            <th>CMT/CCCD</th>
                            <th>MSSV/MCB</th>
                            <th>Trạng thái</th>
                            <th>Hạn trả</th>
                            <th>Ngày tạo</th>
                            <th>Ngày đến lấy</th>
                            <th>Ngày trả</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
