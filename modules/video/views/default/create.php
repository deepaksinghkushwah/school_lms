<?php
/* @var $this yii\web\View */
$this->title = "Create Video";
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/recordrtc/RecordRTC.js', ['position' => $this::POS_HEAD, 'depends' => [\yii\web\JqueryAsset::className()]]);
\app\modules\video\assets\DefaultVideoCreateAsset::register($this);
?>
<h1 id="header">Record Video Content</h1><hr>
<input type="hidden" name="upload_url" id="upload_url" value="<?= \yii\helpers\Url::to(['/video/default/save-video'], true) ?>">
<div class="row">
    <div class="col-md-6">
        <table class="table table-bordered">
            <tr>
                <td>Title</td>
                <td><input class="form-control" type="text" id="title" value="Enter video title" name="title"></td>
            </tr>
            <tr>
                <td>Select Class</td>
                <td>
                    <?= \yii\helpers\Html::dropDownList("class_id", "1", \yii\helpers\ArrayHelper::map(\app\models\LmsMasterClass::find()->all(), 'id', 'title'), ['class' => 'form-control', 'id' => 'classID']) ?>
                </td>
            </tr>
            <tr>
                <td>Select Subject</td>
                <td>
                    <?= \yii\helpers\Html::dropDownList("subject_id", "1", \yii\helpers\ArrayHelper::map(\app\models\LmsMasterSubject::find()->all(), 'id', 'title'), ['class' => 'form-control', 'id' => 'subjectID']) ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <button id="btn-start-recording">Start Recording</button>
        <button id="btn-stop-recording" disabled>Stop Recording</button>
        <button id="btn-save-recording" style="display: none;">Save</button>
        <hr>
        <video width="100%" controls autoplay playsinline></video>

    </div>
</div>

