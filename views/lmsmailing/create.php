<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LmsMailing */

$this->title = 'Send Mail';
$this->params['breadcrumbs'][] = ['label' => 'Mailings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lms-mailing-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
