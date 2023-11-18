<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LmsMedia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lms-media-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'file_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file_name')->fileInput() ?>
    

    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <a href="<?= yii\helpers\Url::to(['/teacher/media/index'],true)?>" class="btn btn-danger">Cancel</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
