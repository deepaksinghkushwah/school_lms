<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LmsExam */

$this->title = 'Create Exam';
$this->params['breadcrumbs'][] = ['label' => 'Exams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lms-exam-create">

    <h1><?= Html::encode($this->title) ?></h1><hr>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
