<?php
/* @var $this yii\web\View */
$this->title = "Teacher's Attendance";

$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/select2/js/select2.full.min.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(yii\helpers\BaseUrl::base() . '/js/select2/css/select2.min.css');



$this->registerCssFile(\yii\helpers\Url::to(['/js/monthpicker/MonthPicker.min.css'], true));
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/monthpicker/MonthPicker.min.js', ['position' => $this::POS_END, 'depends' => [\yii\jui\JuiAsset::className()]]);
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/backend/teacher/export.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);

$teachers = \app\components\GeneralHelper::getUsersByRole("Teacher");
?>
<?= \yii\helpers\Html::beginForm(\yii\helpers\Url::to(['/backend/teacher/export-xls'], true), 'post'); ?>
<div class="row">
    <div class="col-md-2"><input class="form-control" type="text" name="selected_date" id="selectedDate"/></div>
    <div class="col-md-6"><?= \yii\helpers\Html::dropDownList('teacher', '', yii\helpers\ArrayHelper::map($teachers, 'id', 'fullname'), ['class' => 'form-control select2','multiple' => 'multiple']) ?></div>
    <div class="col-md-2"><input type="submit" class="btn btn-primary" name="export" value="Export"/></div>
</div>
<?= \yii\helpers\Html::endForm(); ?>
