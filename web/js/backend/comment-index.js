$(document).ready(function () {
    $('#publish').on('click', function () {
        var length = $('input[name="selection[]"]:checked').length;
        if (length > 0) {
            var ids = [];
            $('input[name="selection[]"]:checked').each(function (idx, element) {
                ids[idx] = $(element).val() + "";
            });

            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure want to publish selected items?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, publish them!',
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $.ajax({
                            async: false,
                            data: {ids: ids},
                            beforeSend: function () {
                            },
                            url: 'publish-selected',
                            type: 'post',
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
        } else {
            Swal.fire("You must select at least one record");
        }
    });

    $('#unpublish').on('click', function () {
        var length = $('input[name="selection[]"]:checked').length;
        if (length > 0) {
            var ids = [];
            $('input[name="selection[]"]:checked').each(function (idx, element) {
                ids[idx] = $(element).val() + "";
            });
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure want to unpublish selected items?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, unpublish them!',
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $.ajax({
                            async: false,
                            data: {ids: ids},
                            beforeSend: function () {
                            },
                            url: 'unpublish-selected',
                            type: 'post',
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
            
        } else {
            Swal.fire("You must select at least one record");
        }
    });
});


