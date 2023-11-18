<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LmsMasterClass */

$this->title = 'Create Course';
$this->params['breadcrumbs'][] = ['label' => 'Course', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lms-master-class-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
