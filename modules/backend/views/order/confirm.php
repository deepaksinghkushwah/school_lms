<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

if ($model->status == 0) {
    $form = yii\widgets\ActiveForm::begin();
    ?>
    <h1>Confirm Order</h1>
    <?= $form->errorSummary([$model]); ?>
    <?= $form->field($model, 'gateway_response')->textarea(['maxlength' => true])->label("Note") ?>
    <p class="help-block">Enter any payment details how customer paid, ie bank cheque, cash or any other method.</p>

    <div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>    
    </div>

    <?php yii\widgets\ActiveForm::end(); ?>


<?php } else { ?>
    This order has been confirmed already.
<?php
}?>