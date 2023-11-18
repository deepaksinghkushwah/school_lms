<?php
/* @var $this yii\web\View */
/* @var $model app\models\LmsVideo */
$this->title = $model->title;
$js = "$('body').bind('contextmenu',function() { return false; });";
$this->registerJs($js);
?>
<h1><?= $this->title ?></h1><hr>
<div class="row">
    <div class="col-md-12">
        <video id="video" width="100%" height="500" controls src="<?= Yii::$app->params['videoPathWeb'].$model->filename ?>"></video>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h1>QA Section</h1>
        <?= $this->render('video-comment-form', ['videoID' => $model->id, 'parentID' => 0, 'textAreaLabel' => 'Post your question here']); ?>
    </div>
</div>
<?= $this->render('video-comment-list', ['videoID' => $model->id]); ?>

