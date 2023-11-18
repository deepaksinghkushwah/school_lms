$(document).ready(function () {
    updateTotal();
    $('#checkAll').on('click', function () {
        if ($(this).is(":checked")) {
            $('#questionTable input[type="checkbox"]').attr('checked', 'checked');
        } else {
            $('#questionTable input[type="checkbox"]').removeAttr('checked');
        }
        updateTotal();
    });

    $('.questionCheckbox').on('click', function () {
        updateTotal();
    });

    $('input[name="score_point"]').on('change', function () {
        updateTotal();
    });

    $('#addQuestionToExam').on('click', function () {
        var data = [];
        var checkedRows = $('#questionTable tr');
        $.each(checkedRows, function (index, row) {
            var qid = $(row).find("input[type='checkbox']");
            var score = $(row).find("input[name='score_point']");
            if (qid.is(":checked")) {
                data.push({qid: qid.val(), score: score.val()});
            }
        });
        console.log(data);
    });
    
    $('#lmsexam-class_id').on('change', function () {
        var classID = $(this).val();
        $.ajax({
            url: $('#getClassSubjectUrl').val(),
            data: {class_id: classID},
            type: "get",
            dataType: 'json',
            success: function (data) {
                if (data.status == "1") {
                    $('#lmsexam-subject_id').empty();
                    $.each(data.subjects, function (index, item) {
                        console.log(item);
                        //var option = $("<option></option>").attr("value", item.id).attr("text", item.title);
                        if($('#lmsexam-subject_id').attr('data-subject-id') == item.id){
                            $('#lmsexam-subject_id').append("<option selected value='"+item.id+"'>"+item.title+"</option>");
                        } else {
                            $('#lmsexam-subject_id').append("<option value='"+item.id+"'>"+item.title+"</option>");
                        }
                        
                    });
                } else {
                    alert("Error");
                }
            }
        });
    })
    
    $('#lmsexam-class_id').trigger("change");
});

function updateTotal() {
    var total = 0.00;
    markSpan = $('#totalMark');

    var checkedRows = $('#questionTable tr');
    $.each(checkedRows, function (index, row) {
        var qid = $(row).find("input[type='checkbox']");
        var score = $(row).find("input[name='score_point']");
        if (qid.is(":checked")) {
            total += parseFloat(score.val());
        }
    });

    markSpan.html(total);
}