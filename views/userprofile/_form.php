<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userprofile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userprofile-form">

    <?php
    $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
                'fieldConfig' => [
                    'template' => "<div class='row'>"
                    . "<div class='col-lg-2'>"
                    . "{label}"
                    . "</div>"
                    . "<div class='col-lg-10'>"
                    . "{input}{error}"
                    . "</div>"
                    . "</div>",
                ]
    ]);
    ?>
    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_line1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'county')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'postcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->fileInput(['class' => 'form-control']) ?>
    <?php
    if ($model && $model->image != '') {
        echo "<div class='row'><div class='col-lg-2'></div><div class='col-lg-10'>";
        echo Html::img(\yii\helpers\Url::to(['/images/profile/' . $model->image], true), ['class' => 'img-thumbnail', 'width' => 100]) . '<br/><br/>';
        echo "</div></div>";
    }
    ?>

    <div class="form-group">
        <?="<div class='row'><div class='col-lg-2'></div><div class='col-lg-10'>";?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <a href="<?= yii\helpers\Url::to(['index'],true)?>" class="btn btn-danger">Cancel</a>
        <?="</div></div>";?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
