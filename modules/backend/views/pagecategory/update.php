<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PageCategory */

$this->title = 'Update Page Category: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Page Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-category-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
