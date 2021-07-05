@extends('index')
@section('title', 'Quản lý nhà xuất bản')

@section('before-adminLTE-styles-end')
<!-- toastr -->
<link rel="stylesheet" href="{{ asset('admin-lte3/plugins/toastr/toastr.min.css') }}">
@endsection

@section ('before-styles-end')
<!-- custom -->
<link rel="stylesheet" href="{{ asset('css/book.css') }}">
@endsection

@section('script')
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
    $(function(){
        $('.edit-pub').click(function(){
            var pub_id = $(this).data('id');
            var pub_name = $(this).data('name');

            $('#pub_id').val(pub_id);
            $('#pub_name').val(pub_name);
        });

        $('.delete-pub').click(function(){
            var pub_id = $(this).data('id');
            $('#publisher_delete_id').val(pub_id);
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
                <h1 class="m-0">Quản lý Nhà xuất bản</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Danh sách Nhà xuất bản</li>
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
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <a href="#" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#modal-add-publisher" data-id="0" data-order="0"
                            data-length="{{ count($publishers) }}">
                            Thêm Nhà xuất bản</a>
                    </div>
                    <div class="card-body">
                        @foreach ($publishers as $publisher)
                        <div class="callout">
                            {{ $publisher->name }}
                            <div class="float-right">
                                <i class="fa fa-edit icon_button edit-pub" data-toggle="modal"
                                    data-target="#modal-edit-publisher" data-id="{{ $publisher->id }}"
                                    data-name="{{ $publisher->name }}" title="Chỉnh sửa"></i>
                                <i class="fa fa-trash icon_button delete-pub" data-toggle="modal"
                                    data-target="#modal-delete-publisher" data-id="{{ $publisher->id }}"
                                    title="Xóa"></i>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="modal-add-publisher" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm Nhà xuất bản</h4>
                </div>
                <form action="{{ route('book.publishers.store') }}" method="POST" name="form-add-pub">
                    @csrf
                    <div class="modal-body">
                        <input class="form-control" type="text" name="pub_name" placeholder="Nhập tên Nhà xuất bản"
                            required>
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
<div id="modal-edit-publisher" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title">Sửa tên Nhà xuất bản</h4>
                </div>
                <form action="{{ route('book.publishers.editPub') }}" method="POST" name="form-edit-pub">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="pub_id" id="pub_id" />
                        <input class="form-control" type="text" id="pub_name" name="pub_name"
                            placeholder="Nhập tên Nhà xuất bản" required>
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
<div id="modal-delete-publisher" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title">Xóa Nhà xuất bản</h4>
                </div>
                <form action="{{ route('book.publishers.deletePub') }}" method="POST" name="form-delete-pub">
                    @csrf
                    <input type="hidden" name="pub_id" id="publisher_delete_id" />
                    <div class="modal-body">
                        <p class="delete-confirm"> Bạn có chắc chắn muốn xóa Nhà xuất bản này? </p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">Đồng ý</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
