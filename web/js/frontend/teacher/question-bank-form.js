$(document).ready(function () {
    
    $('#lmsquestionbank-class_id').on('change', function () {
        var classID = $(this).val();
        $.ajax({
            url:  $('#getClassSubjectUrl').val(),
            data: {class_id: classID},
            type: "get",
            dataType: 'json',
            success: function (data) {
                if (data.status == "1") {
                    $('#lmsquestionbank-subject_id').empty();
                    $.each(data.subjects, function (index, item) {
                        console.log(item);
                        //var option = $("<option></option>").attr("value", item.id).attr("text", item.title);
                        if($('#lmsquestionbank-subject_id').attr('data-subject-id') == item.id){
                            $('#lmsquestionbank-subject_id').append("<option selected value='"+item.id+"'>"+item.title+"</option>");
                        } else {
                            $('#lmsquestionbank-subject_id').append("<option value='"+item.id+"'>"+item.title+"</option>");
                        }
                        
                    });
                } else {
                    alert("Error");
                }
            }
        });
    })
    
    $('#lmsquestionbank-class_id').trigger("change");
});
