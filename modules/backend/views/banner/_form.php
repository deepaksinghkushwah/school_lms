<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
     <?= $form->errorSummary([$model]); ?>
    <?= $form->field($model, 'image')->fileInput(['class' => 'form-control']) ?>
    <?php
    if ($model->image != '') {
        echo "<div class='row'><div class='col-lg-12'>";
        echo Html::img(\yii\helpers\Url::to([Yii::$app->params['bannerPathWeb'] . $model->image], true), ['class' => 'img-thumbnail', 'width' => 100]) . '<br/><br/>';
        echo "</div></div>";
    }
    ?>

    <?= $form->field($model, 'heading')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subheading')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'status')->dropDownList(['1' => 'Published', '0' => 'Unpublished'],['prompt' => 'Select Status']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::button('Cancel', ['class' => 'btn btn-danger', 'onclick' => 'window.location.href="'.\yii\helpers\Url::to(['/backend/banner/index'],true).'"']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
