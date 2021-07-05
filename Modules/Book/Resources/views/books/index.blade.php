@extends('index')
@section('title', 'Quản lý đầu sách')

@section('before-adminLTE-styles-end')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin-lte3/plugins/select2/css/select2.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('admin-lte3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin-lte3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
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
<!-- DataTables  & Plugins -->
<script src="{{ asset('admin-lte3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin-lte3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin-lte3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin-lte3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
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
            dropdownParent: $('#category-select'),
        })
    });
</script>

<script>
    $(function() {
        table = $('#table-book').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            searching: true,
            responsive: true,
            ajax: {
                url: '{{ route("book.books.get") }}',
                type: 'get',
                data: function(d) {
                    d.category_id = $('#category option:selected').val();
                    d.csrf = '{{ csrf_field() }}';
                }
            },
            columns: [
                {data: 'id', sortable: true},
                {data: 'name', sortable: true},
                {data: 'pic_link', orderable: false},
                {data: 'publisher', orderable: false},
                {data: 'page_number', sortable: true},
                {data: 'categories', orderable: false},
                {data: 'content_summary', orderable: false},
                {data: 'author', orderable: false},
                {data: 'status', orderable: false},
                {data: 'quantity', sortable: true},
                {data: 'borrowed', sortable: true},
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

        $('.filter-cate').change(function() {
            table.draw();
        });
    });
</script>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý đầu sách</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Danh sách đầu sách</li>
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
            <a href="{{ route('book.books.create') }}" class="btn btn-primary float-right">
                Thêm đầu sách</a>
            <div class="filter float-right" id="category-select">
                <select class="form-control filter-cate select2" style="width: 100%;" name="cate_id" id="category">
                    <option value="">--Loại sách--</option>
                    @foreach($categories as $cate)
                    <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover projects" id="table-book">
                    <thead>
                        <tr>
                            <th>Mã đầu sách</th>
                            <th>Tên sách</th>
                            <th>Ảnh bìa</th>
                            <th>Nhà xuất bản</th>
                            <th>Số trang</th>
                            <th>Thể loại</th>
                            <th>Mô tả</th>
                            <th>Tác giả</th>
                            <th>Trạng thái</th>
                            <th>Số lượng</th>
                            <th>Đã mượn</th>
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
