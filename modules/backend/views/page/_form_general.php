<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/ckeditor/ckeditor.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
?>


<?php $form = ActiveForm::begin(); ?>

<div class="form-group field-pagecategory-title required">
    <label for="pagecategory-title" class="control-label">Parent Category</label>
    <?= \app\components\PageCategoryTree::drawDropDownTreeAdmin($parentId = 0, $name = 'Page[category_id]', $id = 'Page[category_id]', $exclude = [], $defaultSelected = $model->category_id, $showRoot = false); ?>
    <div class="help-block"></div>
</div>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'content')->textarea(['rows' => 6, 'class' => 'ckeditor']) ?>

<?= $form->field($model, 'allow_comment')->radioList(['1' => 'Yes', '0' => 'No'],['value' => ($model->isNewRecord ? '1' : $model->allow_comment)]) ?>

<?= $form->field($model, 'allow_rating')->radioList(['1' => 'Yes', '0' => 'No'],['value' => ($model->isNewRecord ? '1' : $model->allow_rating)]) ?>

<?= $form->field($model, 'meta_keywords')->textarea(['rows' => 2]) ?>

<?= $form->field($model, 'meta_description')->textarea(['rows' => 2]) ?>

<?= $form->field($model, 'status')->dropDownList(Yii::$app->params['status']) ?>
<div class="form-group">

    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?= Html::a('Cancel', \yii\helpers\Url::to([Yii::$app->controller->id.'/index'],true),['class' => 'btn btn-danger']);?>

</div>

<?php ActiveForm::end(); ?>