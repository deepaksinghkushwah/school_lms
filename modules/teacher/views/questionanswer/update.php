<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LmsQuestionAnswerOption */

$this->title = 'Update Lms Question Answer Option: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lms Question Answer Options', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lms-question-answer-option-update">

    <h1><?= Html::encode($this->title) ?></h1><hr>

    <?= $this->render('_form', [
        'model' => $model,
        'qid' => $qid,
    ]) ?>

</div>
