<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LmsExam */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/frontend/exam/form.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/frontend/teacher/content-form.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
echo Html::hiddenInput("getClassSubjectUrl", yii\helpers\Url::to(['/teacher/content/get-class-subject'],true),['id' => 'getClassSubjectUrl']);
?>

<div class="lms-exam-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class_id')->dropDownList(yii\helpers\ArrayHelper::map(app\models\LmsMasterClass::find()->all(), 'id', 'title'), ['class' => 'form-control']) ?>
    <?= $form->field($model, 'subject_id')->dropDownList(yii\helpers\ArrayHelper::map(app\models\LmsMasterSubject::find()->all(), 'id', 'title'), ['class' => 'form-control']) ?>


    <?= $form->field($model, 'status')->dropDownList(['1' => 'Active', '0' => 'Inactive']) ?>

    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <a href="<?= yii\helpers\Url::to(['/teacher/exam/index'],true)?>" class="btn btn-danger">Cancel</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
