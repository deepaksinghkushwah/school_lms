<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LmsMasterClass */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lms-master-class-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?=$form->errorSummary($model)?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?php
    $subjects = \app\models\LmsMasterSubject::find()->orderBy(['title' => 'SORT_ASC'])->all();
    if ($subjects) {
        ?>
        <h4>Select Course Subjects</h4>
        <div class="row">
            <?php
            $c = 1;
            foreach ($subjects as $sub) {
                $rel = \app\models\LmsClassSubjectRelation::findOne(['class_id' => $model->id, 'subject_id' => $sub->id]);
                $checked = $rel ? 'checked = "checked"' : '';
                ?>
                <div class="col-md-3"><input <?= $checked ?> type="checkbox" name="LmsMasterClass[subjects][]" value="<?= $sub->id ?>"/>&nbsp;<?= $sub->title; ?></div>
                <?php
                if ($c % 3 == 0) {
                    echo "</div><div class='row'>";
                }
                $c++;
            }
            ?>
        </div>
        <?php
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <a class="btn btn-danger" href="<?= \yii\helpers\Url::to(['/backend/course/index'], true) ?>">Cancel</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
