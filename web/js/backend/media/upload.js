$(document).ready(function () {

});
Dropzone.options.myAwesomeDropzone = {
    paramName: "file", // The name that will be used to transfer the file        
    acceptedFiles: 'image/*',
    maxFilesize: 20,
    accept: function (file, done) {
        file.accepted = done();
    },
    init: function () {
        this.on("success", function (file, responseText) {
            // Handle the responseText here. For example, add the text to the preview element:
            file.previewTemplate.appendChild(document.createTextNode("Upload Successful"));

        });
        this.on('complete', function () {
            /*if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                window.location.reload();
            }*/
        });

        this.on('error', function (file, response) {
            $(file.previewElement).find('.dz-error-message').text(response);
        });
    }
};


function removeImageFromGallery(rowId) {
    if (confirm("Are you sure want to remove this image?")) {
        $.ajax({
            url: $('#removeImageUrl').val(),
            data: {row_id: rowId},
            type: 'get',
            dataType: 'json',
            success: function (data) {
                alert(data.msg);
                window.location.reload();
            }
        });
    }
}