$(document).ready(function () {
    $('#attachments').on('fileuploaded', function (event, data, previewId, index) {
        window.location.href = $('#attachmentHref').val();
    });
    $('.btn-remove').on('click', function () {
        var id = $(this).attr('data-row-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure want to remove selected items?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        async: false,
                        data: {id: id},
                        beforeSend: function () {
                        },
                        url: 'delete-attachment',
                        type: 'post',
                        dataType: 'json',
                        success: function (data) {
                            Swal.fire(data.msg);
                            window.location.href = $('#attachmentHref').val();
                        }
                    });
                });

            },
            allowOutsideClick: false
        });

    });



});


