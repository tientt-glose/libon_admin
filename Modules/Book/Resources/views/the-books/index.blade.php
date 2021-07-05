@extends('index')
@section('title', 'Quản lý cuốn sách')

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
<link rel="stylesheet" href="{{ asset('css/thebook.css') }}">
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
    $(document).ready(function() {
        table = $('#table-book').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            searching: false,
            responsive: true,
            ajax: {
                url: '{{ route("book.books.the-books.get") }}',
                type: 'get',
                data: function(d) {
                    d.book_id = '{{ $bookId }}';
                    d.csrf = '{{ csrf_field() }}';
                }
            },
            columns: [
                {data: 'id', sortable: true},
                {data: 'barcode', sortable: true},
                {data: 'status', orderable: false},
                {data: 'publishing_year', sortable: true},
                {data: 'actions', orderable: false},
            ],
            order: [[0, 'desc' ]],
            language: {
                lengthMenu: 'Hiển thị _MENU_ bản ghi trên một trang',
                zeroRecords: 'Không tìm thấy bản ghi phù hợp',
                infoEmpty: 'Không có dữ liệu',
                infoFiltered: '(lọc từ tổng số _MAX_ bản ghi)',
                info: 'Hiển thị từ _START_ đến _END_ trong tổng số _TOTAL_ kết quả',
                paginate: {
                    previous:   '«',
                    next:       '»'
                },
                processing: '<i class="fa fa-spinner fa-pulse fa-fw"></i> Loading'
            },
            columnDefs: [
            ],
            drawCallback: function( settings ) {
                $('.edit-the-book').click(function(){
                    var the_book_id = $(this).data('id');
                    var barcode = $(this).data('barcode');
                    var pub_year = $(this).data('pub-year');

                    $('#the_book_id').val(the_book_id);
                    $('#barcode').val(barcode);
                    $('#pub_year').val(pub_year);
                });
            }
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
                <h1 class="m-0">Quản lý cuốn sách</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('book.books.index') }}">Danh sách đầu sách</a></li>
                    <li class="breadcrumb-item active">Danh sách cuốn sách</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="callout callout-info">
        <div class="row">
            <div class="col-md-2">

                <img src="{{ ($book->pic_link[0] != null) ? url($book->pic_link[0]) : '' }}" alt=""
                    class="preview-image" />
            </div>
            <div class="col-md-10">
                <h5>Thông tin sách</h5>
                <ul>
                    <li> <b>Tên sách: </b> {{ $book->name }}</li>
                    <li> <b>Nhà xuất bản: </b> {{ $book->publisher->name }}</li>
                    <li> <b>Tác giả: </b> {{ $book->author }}</li>
                    <li> <b>Số trang: </b> {{ $book->page_number }}</li>
                    <li> <b>Số lượng: </b> {{ $book->quantity }}</li>
                    <li> <b>Số lượng sách đã mượn: </b> {{ $book->borrowed }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Default box -->
    <div class="card card-primary card-outline">
        <div class="card-header">
            <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-add-the-book">
                Thêm cuốn sách</a>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover projects" id="table-book">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Barcode</th>
                            <th>Trạng thái</th>
                            <th>Năm xuất bản</th>
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

<div id="modal-add-the-book" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm cuốn sách</h4>
                </div>
                <form action="{{ route('book.books.the-books.store', $bookId) }}" method="POST"
                    name="form-add-the-book">
                    @csrf
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
                        <div class="form-group">
                            <label for="pub_year_add">Năm xuất bản</label>
                            <input type="number" class="form-control" id="pub_year_add" name="pub_year"
                                placeholder="Nhập vào năm xuất bản">
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

<div id="modal-edit-the-book" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title">Sửa thông tin sách</h4>
                </div>
                <form action="{{ route('book.the-books.update', $bookId) }}" method="POST" name="form-edit-the-book">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="the_book_id" id="the_book_id" />
                        <div class="form-group">
                            <label for="barcode">Barcode</label>
                            <input type="number" class="form-control" id="barcode" name="barcode"
                                placeholder="Nhập vào barcode của sách" required>
                        </div>
                        <div class="form-group">
                            <label for="pub_year">Năm xuất bản</label>
                            <input type="number" class="form-control" id="pub_year" name="pub_year"
                                placeholder="Nhập vào năm xuất bản">
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
