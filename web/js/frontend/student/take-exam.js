$(document).ready(function () {
    var form = $('#exam-form').show();
//    form.validate({
//        errorPlacement: function errorPlacement(error, element) {
//            element.after(error);
//        },
//        rules: {
//            confirm: {
//                equalTo: "#password"
//            }
//        }
//    });

    $("#wizard").steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true,
        //stepsOrientation: "vertical"
        onFinishing: function (event, currentIndex) {
            var radio_buttons = $("#wizard-p-" + currentIndex + " input[class='answers']");
            if (radio_buttons.filter(':checked').length == 0) {
                $("#wizard-p-" + currentIndex + " .validation-error").html("You must select an answer").show();
                return false;
            } else {
                $("#wizard-p-" + currentIndex + " .validation-error").hide();
                var arr = [];
                $.each($('.answers'), function (index, element) {
                    if ($(element).is(":checked")) {
                        arr.push({qid: $(element).attr('data-qid'), ans_id: $(element).attr('data-ans-id')});
                    }
                });
                $.ajax({
                    url: $('#saveResult').val(),
                    data: {exam_id: $('#examId').val(), answers: arr},
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        alert(data.msg);
                        window.location.href = data.return_url;
                    }
                });
                return true;
            }
        },
        onFinished: function (event, currentIndex) {
            // do nithing after finish
        },
        onStepChanging: function (event, currentIndex, newIndex) {
            //form.validate().settings.ignore = ":disabled,:hidden";
            //return form.valid();
            var radio_buttons = $("#wizard-p-" + currentIndex + " input[class='answers']");
            if (radio_buttons.filter(':checked').length == 0) {
                $("#wizard-p-" + currentIndex + " .validation-error").html("You must select an answer").show();
                return false;
            } else {
                $("#wizard-p-" + currentIndex + " .validation-error").hide();
                return true;
            }
        }
    });

    // dynamically submit steps
    //console.log($("#wizard").steps('finish'));
    $('ul[role="tablist"]').hide();
});