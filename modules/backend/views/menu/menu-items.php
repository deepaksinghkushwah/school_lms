<h4>Manage Menu Items For: <?=$menu->title;?></h4>
<?php
/* @var $this yii\web\View */
/* @var $model app\models\MenuItem */
/* @var $menu app\models\Menu */
use yii\helpers\Html;
$form = \yii\widgets\ActiveForm::begin();
switch ($menu->menu_item_type) {
    case '1': // indivisual
        ?>
        Select items which you want to display in this menu...
        <?php
        echo $form->field($model, 'item_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Page::findAll(['status' => 1]), 'id', 'title'), ['class' => 'form-control', 'multiple' => 'multiple','size' => 10, 'options' =>  $existing]);
        break;
    case '2': // category
        ?>
        Select category which you want to display in this menu...
        <?php
        echo $form->field($model, 'item_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\PageCategory::findAll(['status' => 1]), 'id', 'title'), ['class' => 'form-control','options' =>  $existing]);
        break;
}
?>
<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>
<?php
\yii\widgets\ActiveForm::end();
