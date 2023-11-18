<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/backend/comment-index.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="comment-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>        
        <span class="pull-right">
            <a id="publish" href="javascript:void(0);" class="btn btn-xs btn-primary">Publish Selected</a>
            <a id="unpublish" href="javascript:void(0);" class="btn btn-xs btn-primary">Unpublish Selected</a>
        </span>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
            'page_id' => [
                'attribute' => 'page_id',
                'label' => 'Page',
                'value' => function($model) {
                    return $model->page->title;
                },
            ],
            'user_id' => [
                'attribute' => 'user_id',
                'label' => 'Comment By',
                'value' => function($model) {
                    return $model->user->username;
                },
            ],
            'created_at' => [
                'attribute' => 'created_at',
                'label' => 'Add Date',
                'value' => function($model) {
                    return date(Yii::$app->params['dateFormat'], strtotime($model->created_at));
                }
            ],
            'subject',
            'comment:ntext',
            'status' => [
                'attribute' => 'status',
                'label' => 'Status',
                'value' => function($model) {
                    return $model->status == 1 ? 'Published' : 'Unpublished';
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'contentOptions' => ['style' => 'width:100px;'],
            ],
        ],
    ]);
    ?>
</div>