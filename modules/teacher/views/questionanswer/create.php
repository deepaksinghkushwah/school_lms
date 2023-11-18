<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LmsQuestionAnswerOption */

$this->title = 'Create Lms Question Answer Option';
$this->params['breadcrumbs'][] = ['label' => 'Lms Question Answer Options', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lms-question-answer-option-create">

    <h1><?= Html::encode($this->title) ?></h1><hr>

    <?= $this->render('_form', [
        'model' => $model,
        'qid' => $qid,
    ]) ?>

</div>
