$(document).ready(function () {
    $('#userprofile-country').on('change', function () {
        var countryId = $(this).val();
        $.ajax({
            url: $('#getCountyUrl').val(),
            data: {country_id: countryId},
            dataType: 'json',
            
            success: function (data) {
                $('#userprofile-county').empty();
                $('#userprofile-city').empty();
                if (data.items.length > 0) {
                    $.each(data.items, function (index, item) {
                        $('#userprofile-county').append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                }
            }
        });
    });
    
    $('#userprofile-county').on('change', function () {
        var countyId = $(this).val();
        $.ajax({
            url: $('#getCityUrl').val(),
            data: {county_id: countyId},
            dataType: 'json',
            
            success: function (data) {
                $('#userprofile-city').empty();
                if (data.items.length > 0) {
                    $.each(data.items, function (index, item) {
                        $('#userprofile-city').append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                }
            }
        });
    });
});