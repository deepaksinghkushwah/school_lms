<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LmsMasterSubject */

$this->title = 'Update Subject: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lms-master-subject-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
