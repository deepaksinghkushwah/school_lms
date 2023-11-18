<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LmsContent */

$this->title = 'Create Content';
$this->params['breadcrumbs'][] = ['label' => 'Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lms-content-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
