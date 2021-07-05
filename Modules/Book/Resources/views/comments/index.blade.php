@extends('index')
@section('title', 'Quản lý bình luận')

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
<link rel="stylesheet" href="{{ asset('css/comment.css') }}">
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
            dropdownParent: $('#select-book'),
        })
    });
</script>

<script>
    $(function() {
        table = $('#table-comment').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            searching: true,
            responsive: true,
            ajax: {
                url: '{{ route("book.comments.get") }}',
                type: 'get',
                data: function(d) {
                    // d.category_id = $('#category option:selected').val();
                    d.csrf = '{{ csrf_field() }}';
                }
            },
            columns: [
                {data: 'id', sortable: true},
                {data: 'content', orderable: false},
                {data: 'status', orderable: false},
                {data: 'user', orderable: false},
                {data: 'book', orderable: false},
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
</script>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý bình luận</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Danh sách bình luận</li>
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
            <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-add-comment">
                Thêm bình luận</a>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover projects" id="table-comment">
                    <thead>
                        <tr>
                            <th>Mã bình luận</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Người dùng</th>
                            <th>Sách</th>
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

<div id="modal-add-comment" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm bình luận</h4>
                </div>
                <form action="{{ route('book.comments.store') }}" method="POST" name="form-add-comment">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="callout callout-danger">
                                <h5>Lưu ý</h5>
                                <p>Bình luận đã thêm thì không thể sửa, chỉ có thể xóa.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comment_add">Nội dung</label>
                            <textarea class="form-control" rows="8" id="comment_add" name="content"
                                placeholder="Nhập nội dung bình luận" required></textarea>
                        </div>
                        <div class="form-group" id="select-book">
                            <label for="book_id">Bình luận cho sách</label>
                            <select class="form-control select2" style="width: 100%;" name="book_id" id="book_id"
                                required>
                                <option value="">--Lựa chọn sách--</option>
                                @foreach($books as $book)
                                <option value="{{ $book->id }}">{{ '[' . $book->id . '] ' . $book->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user">Người bình luận</label>
                            <input type="text" class="form-control" id="user" name="user"
                                value="{{ '[' . auth()->user()->id . '] ' . auth()->user()->fullname }}"
                                placeholder="Không khả dụng" disabled>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
