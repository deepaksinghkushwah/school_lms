$(document).ready(function () {
    $('.btnAddQuestionToExam').on('click', function () {
        var examId = $('#examId').val();
        var qid = $(this).attr("data-qid");
        var score = $(this).closest("tr").find(".scorePoint").val();
        //console.log(examId, qid, score);
        $(this).closest("tr").addClass("addedInQuestion");
        $.ajax({
            url: '/teacher/exam/add-question-to-exam',
            data: {exam_id: examId, qid: qid, score: score},
            type: 'get',
            dataType: 'json',
            success: function (data) {
                alert(data.msg);
            }
        });
    });
});
