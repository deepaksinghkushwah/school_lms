<?php
/* @var $this yii\web\View */
/* @var $model app\models\LmsMasterClass */
$this->title = "Select your class";
?>
<h1>Select Class</h1><hr>
<div class="row">
    <?php
    if ($courses) {
        foreach ($courses as $c) {
            $row = \app\models\LmsMasterClass::findOne(['id' => $c['id']]);
            ?>

            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?= $row->title; ?><br>
                        <a href="<?= yii\helpers\Url::to(['/student/default/content-list', 'class_id' => $row->id], true) ?>">Chapters</a>
                        &nbsp;|&nbsp;
                        <a href="<?= yii\helpers\Url::to(['/student/default/video-list', 'class_id' => $row->id], true) ?>">Videos</a>
                    </div>
                </div>
            </div>

            <?php
        }
    }
    ?>
</div>