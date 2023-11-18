<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LmsQuestionAnswerOption */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/ckeditor/ckeditor.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="lms-question-answer-option-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'answer_text')->textarea(['rows' => 6,'class' => 'ckeditor']) ?>

    <?= $form->field($model, 'is_correct_answer')->dropDownList(['1' => 'Yes','0' => 'No']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <a href="<?=Url::to(['/teacher/questionanswer/index','qid' => $qid], true)?>" class="btn btn-danger">Cancel</a>
    </div>

    <?php ActiveForm::end(); ?>


</div>
