<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LmsMailing */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = ['label' => 'Lms Mailings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="lms-mailing-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="mailing-1">From: <?= $model->fromUser->profile->fullname; ?></div>
    <div class="mailing-1">Date: <?= date(Yii::$app->params['dateFormat'] . ' H:i', strtotime($model->created_at)); ?></div>
    <div class="sent-btn">        
        <?=
        Html::a("Back", ['sent'], [
            'class' => 'btn btn-warning btn-xs'
        ])
        ?>
    </div>
    
<div class="mailing-contant"> 
    <?php
    echo $model->message;
    
    ?>
    </div>
</div>
