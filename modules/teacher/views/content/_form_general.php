<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/ckeditor/ckeditor.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/frontend/teacher/content-form.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
/* @var $this yii\web\View */
/* @var $model app\models\LmsContent */
/* @var $form yii\widgets\ActiveForm */
echo Html::hiddenInput("getClassSubjectUrl", yii\helpers\Url::to(['/teacher/content/get-class-subject'],true),['id' => 'getClassSubjectUrl']);
?>

<div class="lms-content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class_id')->dropDownList(yii\helpers\ArrayHelper::map(\app\models\LmsMasterClass::find()->orderBy(['id' => SORT_ASC])->all(), 'id', 'title')) ?>

    <?= $form->field($model, 'subject_id')->dropDownList(yii\helpers\ArrayHelper::map(\app\models\LmsMasterSubject::find()->orderBy(['title' => SORT_ASC])->all(), 'id', 'title'),['data-subject-id' => $model->subject_id]) ?>



    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'class' => 'ckeditor']) ?>


    <?= $form->field($model, 'status')->dropDownList(['1' => 'Active', '0' => 'Inactive']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <a href="<?= Url::to(['/teacher/content/index'],true)?>" class="btn btn-danger">Cancel</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
