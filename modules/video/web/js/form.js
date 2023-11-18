
var video = document.querySelector('video');
var videoBlob = null;

var recorder; // globally accessible

document.getElementById('btn-start-recording').onclick = function () {
    this.disabled = true;
    captureCamera(function (camera) {
        video.muted = true;
        video.volume = 0;
        video.srcObject = camera;

        recorder = RecordRTC(camera, {
            type: 'video'
        });

        recorder.startRecording();

        // release camera on stopRecording
        recorder.camera = camera;

        document.getElementById('btn-stop-recording').disabled = false;
    });
};

document.getElementById('btn-stop-recording').onclick = function () {
    this.disabled = true;
    recorder.stopRecording(stopRecordingCallback);
};

document.getElementById('btn-save-recording').onclick = function () {
    var blob = videoBlob;

    // generating a random file name
    var fileName = getFileName('mp4');

    // we need to upload "File" --- not "Blob"
    var fileObject = new File([blob], fileName, {
        type: 'video/mp4'
    });


    var formData = new FormData();

    // recorded data
    formData.append('video-blob', fileObject);

    // file name
    formData.append('video-filename', fileObject.name);
    
    // additional data
    formData.append('title', $('#title').val());
    formData.append('class_id', $('#classID').val());
    formData.append('subject_id', $('#subjectID').val());
    

    document.getElementById('header').innerHTML = 'Uploading to PHP using jQuery.... file size: (' + bytesToSize(fileObject.size) + ')';

    var upload_url = $("#upload_url").val();
    
    // var upload_url = 'RecordRTC-to-PHP/save.php';

    // upload using jQuery
    $.ajax({
        url: upload_url, // replace with your own server URL
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        type: 'POST',
        success: function (response) {
            if (response.status == 1) {
                alert('Successfully uploaded recorded video');
            } else {
                alert(response.msg); // error/failure
            }
            
            window.location.reload();

        }
    });

    // release camera
    document.getElementById('video').srcObject = document.getElementById('video').src = null;
    camera.getTracks().forEach(function (track) {
        track.stop();
    });

};


function captureCamera(callback) {
    navigator.mediaDevices.getUserMedia({audio: true, video: true}).then(function (camera) {
        callback(camera);
    }).catch(function (error) {
        alert('Unable to capture your camera. Please check console logs.');
        console.error(error);
    });
}

function stopRecordingCallback() {
    $('#btn-save-recording').show();
    video.src = video.srcObject = null;
    video.muted = false;
    video.volume = 1;
    videoBlob = recorder.getBlob();
    video.src = URL.createObjectURL(videoBlob);

    recorder.camera.stop();
    recorder.destroy();
    recorder = null;
}

// this function is used to generate random file name
function getFileName(fileExtension) {
    var d = new Date();
    var year = d.getUTCFullYear();
    var month = d.getUTCMonth();
    var date = d.getUTCDate();
    return 'RecordRTC-' + year + month + date + '-' + getRandomString() + '.' + fileExtension;
}

function getRandomString() {
    if (window.crypto && window.crypto.getRandomValues && navigator.userAgent.indexOf('Safari') === -1) {
        var a = window.crypto.getRandomValues(new Uint32Array(3)),
                token = '';
        for (var i = 0, l = a.length; i < l; i++) {
            token += a[i].toString(36);
        }
        return token;
    } else {
        return (Math.random() * new Date().getTime()).toString(36).replace(/\./g, '');
    }
}