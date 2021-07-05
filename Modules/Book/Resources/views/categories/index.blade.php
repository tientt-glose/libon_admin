@extends('index')
@section('title', 'Quản lý thể loại')

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
        $('.edit-cate').click(function(){
            var cate_id = $(this).data('id');
            var cate_name = $(this).data('name');
            $('#cate_id').val(cate_id);
            $('#cate_name').val(cate_name);
        });

        $('.delete-cate').click(function(){
            var cate_id = $(this).data('id');
            $('#category_delete_id').val(cate_id);
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
                <h1 class="m-0">Quản lý thể loại</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Danh sách thể loại</li>
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
                            data-target="#modal-add-category" data-id="0" data-order="0"
                            data-length="{{ count($categories) }}">
                            Thêm thể loại</a>
                    </div>
                    <div class="card-body">
                        @foreach ($categories as $category)
                        <div class="callout">
                            {{ $category->name }}
                            <div class="float-right">
                                <i class="fa fa-edit icon_button edit-cate" data-toggle="modal"
                                    data-target="#modal-edit-category" data-id="{{ $category->id }}"
                                    data-name="{{ $category->name }}" title="Chỉnh sửa"></i>
                                <i class="fa fa-trash icon_button delete-cate" data-toggle="modal"
                                    data-target="#modal-delete-category" data-id="{{ $category->id }}" title="Xóa"></i>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="modal-add-category" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm thể loại</h4>
                </div>
                <form action="{{ route('book.categories.store') }}" method="POST" name="form-add-cate">
                    @csrf
                    <div class="modal-body">
                        <input class="form-control" type="text" name="cate_name" placeholder="Nhập tên thể loại"
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
<div id="modal-edit-category" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title">Sửa tên thể loại</h4>
                </div>
                <form action="{{ route('book.categories.editCate') }}" method="POST" name="form-edit-cate">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="cate_id" id="cate_id" />
                        <input class="form-control" type="text" id="cate_name" name="cate_name"
                            placeholder="Nhập tên thể loại" required>
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
<div id="modal-delete-category" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h4 class="modal-title">Xóa thể loại</h4>
                </div>
                <form action="{{ route('book.categories.deleteCate') }}" method="POST" name="form-delete-cate">
                    @csrf
                    <input type="hidden" name="cate_id" id="category_delete_id" />
                    <div class="modal-body">
                        <p class="delete-confirm"> Bạn có chắc chắn muốn xóa danh mục này? </p>
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
