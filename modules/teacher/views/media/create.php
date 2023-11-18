<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LmsMedia */

$this->title = 'Create Media';
$this->params['breadcrumbs'][] = ['label' => 'Lms Media', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lms-media-create">

    <h1><?= Html::encode($this->title) ?></h1><hr>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
