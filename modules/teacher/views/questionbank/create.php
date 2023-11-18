<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LmsQuestionBank */

$this->title = 'Create Question';
$this->params['breadcrumbs'][] = ['label' => 'Question Banks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lms-question-bank-create">

    <h1><?= Html::encode($this->title) ?></h1><hr>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
