<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="panel panel-default">    
    <div class="panel-body">
        <div class="row">
            <div class="col-md-1"><img class="img-responsive" src="<?=  yii\helpers\Url::to(['/images/news.png'],true);?>"/></div>
            <div class="col-md-11">
                <span class="label label-default"><?= date('M d, Y', $model->add_date) ?></span> 
                <strong><a href="<?= yii\helpers\Url::to(['/' . $model->alias], true) ?>"><?= Html::encode($model->title) ?></a></strong><br/>
                <?= substr(strip_tags($model->content), 0, 300) . '...' ?> <br/>
                <span class="pull-right"><?= Html::a('Read More', yii\helpers\Url::to(['/' . $model->alias], true), ['class' => 'btn btn-xs btn-primary']) ?>   </span>

            </div>
        </div>

    </div>
</div>
