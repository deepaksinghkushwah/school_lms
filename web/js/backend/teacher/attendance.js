$(document).ready(function () {
    $('.btnCheckAll').on('click', function () {
        if ($(this).is(":checked")) {
            $('.attendanceCheckbox').each(function (index, element) {
                $(element).attr('checked', 'checked');
            });
        } else {
            $('.attendanceCheckbox').each(function (index, element) {
                $(element).removeAttr('checked');
            });
        }
    });

    $('.removeEntry').on('click', function () {
        var url = $(this).attr('data-href');
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure want to delete this entry?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        beforeSend: function () {
                        },
                        url: url,
                        type: 'get',
                        dataType: 'json',
                        success: function (data) {
                            Swal.fire(data.msg);
                            window.location.reload();
                        }
                    });
                });

            },
            allowOutsideClick: false
        });

    });

});
