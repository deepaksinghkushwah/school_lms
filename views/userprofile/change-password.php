<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->title = 'Change password';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'description', 'content' => $this->title]);
?>
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1><hr>

    <p>Please choose your new password:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'change-password-form']); ?>
            <?= $form->field($model, 'old_password')->passwordInput() ?>
            <?= $form->field($model, 'new_password')->passwordInput() ?>
                <?= $form->field($model, 'confirm_password')->passwordInput() ?>
            <div class="form-group">
            <?= Html::submitButton('Update Password', ['class' => 'btn btn-primary']) ?>
                <a href="<?= yii\helpers\Url::to(['index'],true)?>" class="btn btn-danger">Cancel</a>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
