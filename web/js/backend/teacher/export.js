$(document).ready(function () {
    $('#selectedDate').MonthPicker({
        Button: false,
        MonthFormat: "mm-yy",
        MaxMonth: 0,
    });
    
    $('.select2').select2({
        allowClear: true
    });
});