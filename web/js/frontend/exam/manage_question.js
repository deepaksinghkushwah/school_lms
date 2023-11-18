$(document).ready(function () {
    $('.deleteQuestion').on('click', function () {
        var id = $(this).attr('data-id');
        if (confirm("Are you sure want to delete this question from current exam?")) {
            $.ajax({
                url: $('#deleteQuestionUrl').val(),
                data: {row_id: id},
                type: 'get',
                dataType: 'json',
                success: function (data) {
                    alert(data.msg);
                    window.location.reload();
                }
            });
        }
    });

    $('.saveScorePoint').on('click', function () {
        var id = $(this).attr('data-id');
        var score  = $(this).closest("tr").find('input.scorePoint').val();
        var sortOrder  = $(this).closest("tr").find('input.sortOrder').val();
        //console.log("RowId: " + id + ", Score: "+score + ", Sort: "+sortOrder);
        updateQuestion(id, score, sortOrder);       
    });
    
    $('.sortOrder, .scorePoint').on('change', function () {
        var id = $(this).attr('data-id');
        var score  = $(this).closest("tr").find('input.scorePoint').val();
        var sortOrder  = $(this).closest("tr").find('input.sortOrder').val();
        //console.log("RowId: " + id + ", Score: "+score + ", Sort: "+sortOrder);
        updateQuestion(id, score, sortOrder);       
    });
});

function updateQuestion(id, score, sortOrder){
     $.ajax({
            url: $('#updateQuestionScoreUrl').val(),
            data: {row_id: id, score_point: score, sort_order: sortOrder},
            type: 'get',
            dataType: 'json',
            success: function (data) {
                alert(data.msg);
                window.location.reload();
            }
        });
}