@extends('index')
@section('title', 'Thêm đầu sách')

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
<!-- bs-custom-file-input -->
<script src="{{ asset('admin-lte3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('admin-lte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin-lte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- toastr -->
<script src="{{ asset('admin-lte3/plugins/toastr/toastr.min.js') }}"></script>
<!-- custom -->
<script src="{{ asset('js/book.js') }}"></script>

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
        $('.selectPub').select2({
            width: 'resolve',
            allowClear: true
            // dropdownParent: $('#category-select')
        })
    });

    $(document).ready(function() {
    //Initialize Select2 Elements
        $('.selectCate').select2({
            width: 'resolve',
            allowClear: true,
            closeOnSelect: false
            // dropdownParent: $('#category-select')
        })
    });

    $(document).ready(function () {
        bsCustomFileInput.init();
    });
</script>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Thêm đầu sách</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('book.books.index') }}">Danh sách đầu sách</a></li>
                    <li class="breadcrumb-item active">Thêm đầu sách</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form action="{{ route('book.books.store') }}" method="post" enctype="multipart/form-data" id="validateForm">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Phần nhập thông tin sách</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="book_name">Tên đầu sách</label>
                                <input type="text" class="form-control" id="book_name" name="book_name"
                                    placeholder="Nhập vào tên đầu sách">
                            </div>
                            <div class="form-group" id="pub-select">
                                <label for="pub_selection">Nhà xuất bản</label>
                                <select class="form-control selectPub" id="pub_selection" name="pub_id"
                                    data-placeholder="Chọn tên Nhà xuất bản" style="width: 100%;">
                                    <option value=""></option>
                                    @foreach($selectedPublishers as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="page_number">Số trang</label>
                                <input type="number" class="form-control" id="page_number" name="page_number"
                                    placeholder="Nhập vào số trang sách">
                            </div>
                            <div class="form-group" id="category-select">
                                <label for="category-selection">Thể loại</label>
                                <select class="form-control selectCate" multiple="multiple" id="category-selection"
                                    name="cate_id[]" data-placeholder="Chọn tên thể loại" style="width: 100%;">
                                    @foreach($selectedCategories as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="content">Tóm tắt nội dung</label>
                                <textarea class="form-control" rows="3" id="content" name="content"
                                    placeholder="Nhập nội dung tóm tắt, mô tả sách"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="author">Tác giả</label>
                                <input type="text" class="form-control" id="author" name="author"
                                    placeholder="Nhập vào tên tác giả">
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Phần nhập file</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="pdf">File PDF đọc thử sách</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="pdf" id="pdf">
                                    <label class="custom-file-label" for="pdf">Chọn file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pic_1">Ảnh 1 (ảnh chính)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input preview-upload-image"
                                        name="cover_path[]" id="pic_1">
                                    <label class="custom-file-label" for="pic_1">Chọn file</label>
                                </div>
                                <img src="" alt="" class="preview-image" />
                            </div>
                            <div class="form-group">
                                <label for="pic_2">Ảnh 2 (ảnh phụ)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input preview-upload-image"
                                        name="cover_path[]" id="pic_2">
                                    <label class="custom-file-label" for="pic_2">Chọn file</label>
                                </div>
                                <img src="" alt="" class="preview-image" />
                            </div>
                            <div class="form-group">
                                <label for="pic_3">Ảnh 3</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input preview-upload-image"
                                        name="cover_path[]" id="pic_3">
                                    <label class="custom-file-label" for="pic_3">Chọn file</label>
                                </div>
                                <img src="" alt="" class="preview-image" />
                            </div>
                            <div class="form-group">
                                <label for="pic_4">Ảnh 4</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input preview-upload-image"
                                        name="cover_path[]" id="pic_4">
                                    <label class="custom-file-label" for="pic_4">Chọn file</label>
                                </div>
                                <img src="" alt="" class="preview-image" />
                            </div>
                            <div class="form-group">
                                <label for="pic_5">Ảnh 5</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input preview-upload-image"
                                        name="cover_path[]" id="pic_5">
                                    <label class="custom-file-label" for="pic_5">Chọn file</label>
                                </div>
                                <img src="" alt="" class="preview-image" />
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="{{ route('book.books.index') }}" class="btn btn-default float-right">Hủy</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
