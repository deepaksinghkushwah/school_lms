<?php
/* @var $this yii\web\View */
/* @var $model app\models\LmsContent */
$this->title = ucfirst($model->title);
$this->registerCss("p{text-align: justify;}");
?>

<h1><?= $this->title ?></h1>
<p>
    Class: <a href="<?= yii\helpers\Url::to(['/student/default/content-list','class_id' => $model->class_id],true)?>"><b><?= $model->class->title; ?></b></a>, Subject: <b><?= $model->subject->title ?></b>
    <br>
    Author: <b><?=$model->author->fullname;?></b>, Date: <?=date(Yii::$app->params['dateFormat'],strtotime($model->created_at))?>
</p>
<hr>
<?php
if (count($model->lmsContentAttachments) > 0) {
    ?>
    <h4>Attachments</h4>
    <div class="row">
        <?php
        foreach ($model->lmsContentAttachments as $attachment) {
            ?>
            <div class="col-md-3">
                <div class="well">
                    <a href="<?= yii\helpers\Url::to(['/site/download-content-file','id' => $attachment->id],true);?>">
                        <?= $attachment->file_title ?>
                    </a>
                    <br>[Type: .<?=$attachment->file_type?>]
                </div>
            </div>

            <?php
        }
        ?>
    </div>
    <hr>
    <?php
}
?>
<?= $model->content; ?>