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
<div class="lms-mailing-view listView-home">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="mailing-top-add">
        <div class="mailing-f"> From: <?= $model->fromUser->profile->fullname; ?></div>
        <div class="mailing-f2">Date: <?= date(Yii::$app->params['dateFormat'] . ' H:i', strtotime($model->created_at)); ?></div>
    </div>

    <div class="top-mail-icon ">        
        <?=
        Html::a("Back", ['index'], [
            'class' => 'btn btn-warning btn-xs'
        ])
        ?>
        <?=
        Html::a("Reply", ['reply', 'id' => $model->id], [
            'class' => 'btn btn-primary btn-xs'
        ])
        ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-xs',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
        <br><br>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            &nbsp;
            <div class="pull-left"><i class="fa fa-calendar" aria-hidden="true"></i> <?= date(Yii::$app->params['dateFormat'] . ' H:i', strtotime($model->created_at)); ?></div>
            <div class="pull-right"><i class="fa fa-user" aria-hidden="true"></i> <?= $model->fromUser->profile->fullname; ?>
            </div>      
        </div>
        <div class="panel-body"><?php echo $model->message; ?></div>
    </div>
    <div class="prv_msg_top"> 
        <?php
        if ($model->parent_id != 0) {
            $threads = \app\modules\email\components\EmailHelper::getEmailThread($model->id);

            if ($threads) {
                ?>  

                <h3>Previous Messages Thread</h3>


                <?php
                foreach ($threads as $emodel) {
                    ?>                

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            &nbsp;
                            <div class="pull-left"><i class="fa fa-calendar" aria-hidden="true"></i> <?= date(Yii::$app->params['dateFormat'] . ' H:i', strtotime($emodel->created_at)); ?></div>
                            <div class="pull-right"><i class="fa fa-user" aria-hidden="true"></i> <?= $emodel->fromUser->profile->fullname; ?>
                            </div>      
                        </div>

                        <div class="panel-body"><strong><?= $emodel->subject ?></strong><br><br> <?= $emodel->message; ?></div>

                    </div>                      

                    <?php
                }
                ?>
                <?php
            }
        }
        ?>
    </div>  
</div>
