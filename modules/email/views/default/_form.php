<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Mailing */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/select2/js/select2.full.min.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(yii\helpers\BaseUrl::base() . '/js/select2/css/select2.min.css');
$this->registerJs("$('.select2').select2();");
//$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/ckeditor/ckeditor.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJs("CKEDITOR.replace( '.ckeditor' );");
$users = \yii\helpers\ArrayHelper::map(app\models\Userprofile::find()->where("user_id != ".Yii::$app->user->id)->all(),'user_id','fullname');
?>

<div class="lms-mailing-form">
<h1>Send Email</h1>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'to_user')->dropDownList($users,['multiple' => 'multiple','class' => 'select2 form-control']) ?>
    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'message')->textarea(['rows' => 6,'class' => 'form-control']) ?>
    
    <div class="form-group submitButton">
        <?= Html::submitButton('<i class="fa fa-paper-plane" aria-hidden="true"></i> Send', ['class' => 'btn btn-success']) ?>
        <a href="<?= yii\helpers\Url::to(['/email/default/index']);?>" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
