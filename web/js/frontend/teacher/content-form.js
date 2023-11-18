$(document).ready(function () {
    
    $('#lmscontent-class_id').on('change', function () {
        var classID = $(this).val();
        $.ajax({
            url: 'get-class-subject',
            data: {class_id: classID},
            type: "get",
            dataType: 'json',
            success: function (data) {
                if (data.status == "1") {
                    $('#lmscontent-subject_id').empty();
                    $.each(data.subjects, function (index, item) {
                        console.log(item);
                        //var option = $("<option></option>").attr("value", item.id).attr("text", item.title);
                        if($('#lmscontent-subject_id').attr('data-subject-id') == item.id){
                            $('#lmscontent-subject_id').append("<option selected value='"+item.id+"'>"+item.title+"</option>");
                        } else {
                            $('#lmscontent-subject_id').append("<option value='"+item.id+"'>"+item.title+"</option>");
                        }
                        
                    });
                } else {
                    alert("Error");
                }
            }
        });
    })
    
    $('#lmscontent-class_id').trigger("change");
});
