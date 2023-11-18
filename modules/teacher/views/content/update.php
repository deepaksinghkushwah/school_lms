<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LmsContent */

$this->title = 'Update Content: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lms-content-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
