$(document).ready(function () {
    changeProgressStep();
    formValidate()
})

var order_status = parseInt($('#order_status').val());
function changeProgressStep() {
    var i = 1;
    var raw_deadline = $('span#deadline').text().trim()
    var raw_restore = $('span#restore').text().trim()

    if (raw_deadline != '' && raw_restore != '' && raw_deadline != undefined && raw_restore != undefined) {
        deadline = moment(raw_deadline, 'DD-MM-YYYY HH:mm').format('YYYY-MM-DD HH:mm')
        deadline_coming = moment(raw_deadline, 'DD-MM-YYYY HH:mm').subtract(3, 'days').format('YYYY-MM-DD HH:mm')
        restore = moment(raw_restore, 'DD-MM-YYYY HH:mm').format('YYYY-MM-DD HH:mm')

        if (restore > deadline_coming) {
            console.log(1)
            $('#second-child').after(
                '<div class="col-md-2 status" id="third-child">' +
                '<div class="circle ml-4">' +
                '<i class="fa fa-check"></i>' +
                '<i class="fa fa-times"></i>' +
                '<i class="fa fa-sync-alt fa-spin"></i>' +
                '</div>' +
                '<div class="line ml-4"></div>' +
                '<div class="progress">' +
                '<div class="progress-bar" role="progressbar">' +
                'Sắp tới hạn trả' +
                '</div>' +
                '</div>' +
                '</div>'
            )
        }

        if (restore > deadline) {
            console.log(2)
            $('#third-child').after(
                '<div class="col-md-2 status">' +
                '<div class="circle ml-2">' +
                '<i class="fa fa-check"></i>' +
                '<i class="fa fa-times"></i>' +
                '<i class="fa fa-sync-alt fa-spin"></i>' +
                '</div>' +
                '<div class="line ml-3"></div>' +
                '<div class="progress">' +
                '<div class="progress-bar" role="progressbar">' +
                'Quá hạn' +
                '</div>' +
                '</div>' +
                '</div>'
            )
        }
    }

    switch (order_status) {
        case 3:
            $('#second-child').after(
                '<div class="col-md-2 status" id="third-child">' +
                '<div class="circle ml-4">' +
                '<i class="fa fa-check"></i>' +
                '<i class="fa fa-times"></i>' +
                '<i class="fa fa-sync-alt fa-spin"></i>' +
                '</div>' +
                '<div class="line ml-4"></div>' +
                '<div class="progress">' +
                '<div class="progress-bar" role="progressbar">' +
                'Sắp tới hạn trả' +
                '</div>' +
                '</div>' +
                '</div>'
            )
            break;
        case 4:
            $('#second-child').after(
                '<div class="col-md-2 status" id="third-child">' +
                '<div class="circle ml-4">' +
                '<i class="fa fa-check"></i>' +
                '<i class="fa fa-times"></i>' +
                '<i class="fa fa-sync-alt fa-spin"></i>' +
                '</div>' +
                '<div class="line ml-4"></div>' +
                '<div class="progress">' +
                '<div class="progress-bar" role="progressbar">' +
                'Sắp tới hạn trả' +
                '</div>' +
                '</div>' +
                '</div>'
            )
            $('#third-child').after(
                '<div class="col-md-2 status">' +
                '<div class="circle ml-2">' +
                '<i class="fa fa-check"></i>' +
                '<i class="fa fa-times"></i>' +
                '<i class="fa fa-sync-alt fa-spin"></i>' +
                '</div>' +
                '<div class="line ml-3"></div>' +
                '<div class="progress">' +
                '<div class="progress-bar" role="progressbar">' +
                'Quá hạn' +
                '</div>' +
                '</div>' +
                '</div>'
            )
            break;
        default:
            break;
    }

    if (order_status > 0 && order_status < 5) {
        $('#progress-bar > div').each(function () {
            if ($(this).hasClass('cancel')) $(this).removeClass('cancel');
            if ($(this).hasClass('done')) $(this).removeClass('done');
            if ($(this).hasClass('spin')) $(this).removeClass('spin');
            if ($(this).hasClass('wait')) $(this).removeClass('wait');

            if (i < order_status) {
                $(this).addClass('done');
            }
            else if (i > order_status) {
                $(this).addClass('wait');
            }
            else $(this).addClass('spin');
            i++;
        });
    } else if (order_status == 5) {
        $('#progress-bar > div').each(function () {
            if ($(this).hasClass('cancel')) $(this).removeClass('cancel');
            if ($(this).hasClass('done')) $(this).removeClass('done');
            if ($(this).hasClass('spin')) $(this).removeClass('spin');
            if ($(this).hasClass('wait')) $(this).removeClass('wait');

            $(this).addClass('done');
        });
    }
    else if (order_status == 0) {
        $('#progress-bar > div')[2].remove();
        $('#progress-bar > div')[1].remove();
        $('#progress-bar > div').removeClass('spin')
        $('#progress-bar > div').addClass('done');
        $('#progress-bar').append(
            '<div class="col-md-2 status cancel">' +
            '<div class="circle">' +
            '<i class="fa fa-check"></i>' +
            '<i class="fa fa-times"></i>' +
            '<i class="fa fa-sync-alt fa-spin"></i>' +
            '</div>' +
            '<div class="progress ml-2">' +
            '<div class="progress-bar" role="progressbar">' +
            'Hủy' +
            '</div>' +
            '</div>' +
            '</div>'
        );
    }
}

function formValidate() {
    $.validator.addMethod("require_barcode", function (value, element) {
        var barcode = []
        var result = true
        $('#order-table-body tr input').each(function () {
            barcode.push($(this).val())
        })

        barcode.forEach(function (value) {
            if (value == '' || value == null || value == undefined) {
                result = false
                return result
            }
        })
        return result
    })

    $('#validateForm').validate({
        ignore: [],
        rules: {
            "barcode[]": {
                require_barcode: true,
            },
            "address": {
                required: true
            }
        },
        messages: {
            "barcode[]": {
                require_barcode: function () {
                    toastr.error('Vui lòng nhập/trả hết sách trong đơn')
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
