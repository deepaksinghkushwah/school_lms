<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LmsNotification */

$this->title = 'Create Lms Notification';
$this->params['breadcrumbs'][] = ['label' => 'Lms Notifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lms-notification-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
