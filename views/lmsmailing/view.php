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
    <div><strong>From:</strong> <?=$model->fromUser->profile->fullname;?></div>
    <div><strong>Date:</strong> <?=date(Yii::$app->params['dateFormat'],strtotime($model->created_at));?></div>
    <hr/>
    <p class="pull-right">        
        <?=Html::a("Back",['index'],[
            'class' => 'btn btn-warning btn-xs'
        ])
            
            ?>
        <?=Html::a("Reply",['reply','id' => $model->id],[
            'class' => 'btn btn-primary btn-xs'
        ])
            
            ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-xs',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p><br>

    <?php
    echo $model->message;
    ?>

</div>
