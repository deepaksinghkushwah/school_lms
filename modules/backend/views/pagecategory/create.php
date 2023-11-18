<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PageCategory */

$this->title = 'Create Page Category';
$this->params['breadcrumbs'][] = ['label' => 'Page Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-category-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
