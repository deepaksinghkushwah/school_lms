<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LmsMailing */
/* @var $form yii\widgets\ActiveForm */
//$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/ckbasic/ckeditor.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJs("CKEDITOR.replace( '.ckeditor' );");
?>
<div class="lms-mailing-create">
<div class="lms-mailing-form">
<h1>Reply</h1>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'message')->textarea(['rows' => 6,'class' => 'form-control']) ?>
    
    <div class="submitButton">
        <?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
</div>