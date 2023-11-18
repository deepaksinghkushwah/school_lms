<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
if ($model) {
    $this->title = $model->title;
    $this->params['breadcrumbs'][] = $this->title;
    $this->registerMetaTag(['name' => 'keywords', 'content' => !empty($model->meta_keywords) ? $model->meta_keywords : $model->title]);
$this->registerMetaTag(['name' => 'description', 'content' => !empty($model->meta_description) ? $model->meta_description : $model->title]);
    ?>


    <h1><?= Html::encode($this->title) ?></h1>

    <span class="small">On <?= date(Yii::$app->params['dateFormat'], $model->add_date) ?><br/></span>
    <span class="label label-default">
        <i class="fa fa-user"></i> <?= Yii::$app->params['adminName'] ?>
    </span>
    <hr/>

    <?= $model->content; ?>
    <hr/>
    <?php
    echo $this->render('_attachments', ['pageModel' => $model]);
    echo $this->render('_rating', ['pageModel' => $model, 'newRatingModel' => $newRatingModel]);
    echo $this->render('_comments', ['pageModel' => $model, 'newCommentModel' => $newCommentModel]);
} else {
    throw new yii\web\HttpException(404, "Page Not Found");
}