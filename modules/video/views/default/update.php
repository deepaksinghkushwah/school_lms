<?php
/* @var $this yii\web\View */
/* @var $model app\models\LmsVideo */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = "Update Video: " . $model->title;
?>
<div class="lms-video-form">
    <h1><?= $this->title; ?></h1><hr>

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'class_id')->dropDownList(yii\helpers\ArrayHelper::map(app\models\LmsMasterClass::find()->all(), 'id', 'title'), ['class' => 'form-control']) ?>
            <?= $form->field($model, 'subject_id')->dropDownList(yii\helpers\ArrayHelper::map(app\models\LmsMasterSubject::find()->all(), 'id', 'title'), ['class' => 'form-control']) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <a href="<?= yii\helpers\Url::to(['/video/default/index'], true) ?>" class="btn btn-danger">Cancel</a>
            </div>
        </div>
        <div class="col-md-6">
            <p>Note: You can not edit video, only title, class and subjects selections are editable</p>
            <video width="100%" controls src="<?= Yii::$app->params['videoPathWeb'] . $model->filename ?>"></video>
        </div>
    </div>




    <?php ActiveForm::end(); ?>

</div>
