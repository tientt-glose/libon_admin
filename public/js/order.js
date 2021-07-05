$(document).ready(function () {
    formValidate()
})
function formValidate() {
    $.validator.addMethod("duplicate_book_id", function (value, element) {
        var book_id = []
        var book_id_copy = []
        $('#order-table-body tr td:nth-child(3)').each(function () {
            book_id.push($(this).text())
        })
        book_id_copy = book_id
        book_id.sort()
        book_id_copy.sort()
        return book_id.length == $.uniqueSort(book_id_copy).length
    })

    $.validator.addMethod("duplicate_barcode", function (value, element) {
        var barcode = []
        var barcode_copy = []
        $('#order-table-body tr td:nth-child(2)').each(function () {
            barcode.push($(this).text())
        })
        barcode_copy = barcode
        barcode.sort()
        barcode_copy.sort()
        return barcode.length == $.uniqueSort(barcode_copy).length
    })

    $('#validateForm').validate({
        ignore: [],
        rules: {
            user_id: {
                required: true,
            },
            "book_id[]": {
                duplicate_book_id: true,
            },
            "barcode[]": {
                duplicate_barcode: true,
            },
            "address": {
                required: true
            }
        },
        messages: {
            "user_id": {
                required: function () {
                    toastr.error('Thiếu thông tin người đặt mượn')
                },
            },
            "book_id[]": {
                duplicate_book_id: function () {
                    toastr.error('Mỗi đơn chỉ được mượn 1 đầu sách')
                },
            },
            "barcode[]": {
                duplicate_barcode: function () {
                    toastr.error('Trong đơn có trường hợp mã sách giống nhau')
                }
            },
            "address": {
                required: function () {
                    toastr.error('Vui lòng nhập địa chỉ nhận sách')
                }
            }
        },
        errorElement: 'span',
    })
}
