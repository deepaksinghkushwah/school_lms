<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PageCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group field-pagecategory-parent_id required">
        <label for="pagecategory-parent_id" class="control-label">Parent Category</label>
        <?= \app\components\PageCategoryTree::drawDropDownTreeAdmin($parentId = 0, $name = 'PageCategory[parent_id]', $id = 'PageCategory[parent_id]', $exclude = [$model->id], $defaultSelected = $model->parent_id, $showRoot = true); ?>
        <div class="help-block"></div>
    </div>

    

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(['1' => 'Active', '0' => 'Inactive']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Cancel', \yii\helpers\Url::to([Yii::$app->controller->id.'/index'],true),['class' => 'btn btn-danger']);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
