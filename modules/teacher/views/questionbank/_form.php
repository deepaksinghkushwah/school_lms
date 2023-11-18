<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LmsQuestionBank */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/ckeditor/ckeditor.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/frontend/teacher/question-bank-form.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
echo Html::hiddenInput("getClassSubjectUrl", yii\helpers\Url::to(['/teacher/content/get-class-subject'],true),['id' => 'getClassSubjectUrl']);
?>

<div class="lms-question-bank-form">

    <?php $form = ActiveForm::begin(); ?>
    <table class="table table-bordered table-striped">
        <tr>
            <td><?= $form->field($model, 'class_id')->dropDownList(yii\helpers\ArrayHelper::map(app\models\LmsMasterClass::find()->all(), 'id', 'title'), ['class' => 'form-control']) ?></td>
            <td><?= $form->field($model, 'subject_id')->dropDownList(yii\helpers\ArrayHelper::map(app\models\LmsMasterSubject::find()->all(), 'id', 'title'), ['class' => 'form-control']) ?></td>
        </tr>
        <tr>
            <td colspan="2"><?= $form->field($model, 'question_text')->textarea(['rows' => 6,'class' => 'ckeditor']) ?></td>
        </tr>
        <tr>
            <td>
            <?= $form->field($model, 'score_point')->textInput() ?>
                <p class="help-block">Numbers like 1,2,3 or decimal 10.40, 20.5</p>
            </td>
            <td><?= $form->field($model, 'status')->dropDownList(['1' => 'Active', '0' => 'Inactive']) ?></td>
        </tr>
    </table>











    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <a href="<?= yii\helpers\Url::to(['/teacher/questionbank/index'],true)?>" class="btn btn-danger">Cancel</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
