<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Theme */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="theme-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'filename')->fileInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inverse')->radioList(['inverse' => 'Inverse','light' => 'Light'],['class' => 'form-control']) ?>
    
    <?= $form->field($model, 'default')->dropDownList(['1' => 'Yes','0' => 'No']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
