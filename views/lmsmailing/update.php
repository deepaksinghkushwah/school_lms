<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LmsMailing */

$this->title = 'Update Mailing: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lms Mailings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lms-mailing-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
