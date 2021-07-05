$(document).ready(function () {
    previewUploadImage();

    formValidate()

});

window.onbeforeunload = function () {
    // Show loading
    $('.box .overlay').removeClass('hide');
};

function formValidate() {
    $.validator.setDefaults({
        // submitHandler: function () {
        //     alert("Form successful submitted!");
        // }
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
    $('#validateForm').validate({
        ignore: [],
        rules: {
            book_name: {
                required: true,
            },
            pub_id: {
                required: true,
            },
            page_number: {
                required: true,
                digits: true,
                min: 1
            },
            "cate_id[]": {
                required: true,
            },
            content: {
                required: true,
            },
            author: {
                required: true,
            },
            "cover_path[]": {
                required: true
            }
        },
        messages: {
            book_name: {
                required: "Vui lòng nhập tên đầu sách",
            },
            pub_id: {
                required: "Vui lòng chọn Nhà xuất bản",
            },
            page_number: {
                required: "Vui lòng nhập số trang sách",
                digits: "Vui lòng nhập chỉ chữ số",
                min: "Vui lòng nhập số trang lớn hơn 1"
            },
            "cate_id[]": {
                required: "Vui lòng chọn thể loại",
            },
            content: {
                required: "Vui lòng nhập nội dung tóm tắt",
            },
            author: {
                required: "Vui lòng nhập tên tác giả",
            },
            "cover_path[]": {
                required: "Vui lòng chọn ảnh 1 (ảnh chính)"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
    });
}

function previewUploadImage() {
    $(".preview-upload-image").on('change', function () {
        readURL(this);
    });
}

//todo: giai thich
function readURL(input) {
    var imgElm = $(input).parents(".form-group").find('img.preview-image');
    console.log(imgElm.length);

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            imgElm.attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
        imgElm.show();
    }
}
