<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LmsMasterClass */

$this->title = 'Update Course: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Course', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lms-master-class-update">
    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
