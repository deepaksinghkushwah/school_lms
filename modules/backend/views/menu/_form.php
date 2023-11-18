<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location')->dropDownList(Yii::$app->params['menu']['locations']) ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?php // $form->field($model, 'menu_type')->dropDownList(Yii::$app->params['menu']['types']) ?>

    <?= $form->field($model, 'menu_item_type')->dropDownList(Yii::$app->params['menu']['item_type']) ?>



    <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['status']) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <a href="<?= \yii\helpers\Url::to(['/backend/menu/index'],true);?>" class="btn btn-danger">Cancel</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
