<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LmsMailing */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/select2/js/select2.full.min.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(yii\helpers\BaseUrl::base() . '/js/select2/css/select2.min.css');
$this->registerJs("$('.select2').select2();");
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/ckeditor/ckeditor.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs("CKEDITOR.replace( '.ckeditor' );");
$super = \app\components\GeneralHelper::getUsersListByRole("Super Admin");
$usersStudent = \app\components\GeneralHelper::getUsersListByRole("Student");
$usersTeacher =\app\components\GeneralHelper::getUsersListByRole("Teacher");
$users = array_merge($super, $usersTeacher, $usersStudent);
?>

<div class="lms-mailing-form">
<h1>Send Email</h1><hr>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'to_user')->dropDownList(\yii\helpers\ArrayHelper::map($users,'id','name'),['multiple' => 'multiple','class' => 'select2 form-control']) ?>
    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'message')->textarea(['rows' => 6,'class' => 'ckeditor']) ?>
    
    

    <div class="form-group">
        <?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
        <a href="<?= yii\helpers\Url::to(['/lmsmailing/index']);?>" class="btn btn-danger">Cancel</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
