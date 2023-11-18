<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LmsMediaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Media';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lms-media-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <p>
        <?= Html::a('Create Media', ['create'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Reset Search', ['index'], ['class' => 'btn btn-danger']) ?>
    </p>
    

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','contentOptions' => ['width' => '10%']],            
            'file_title',
            'file_name' => [
                'label' => 'File',
                'format' => 'html',
                'value' => function($model) {
                    return Html::img(yii\helpers\Url::to([Yii::$app->params['mediaPathWeb'] . $model->file_name], true), ['class' => 'img-rounded','style' => 'width: 100px']);
                }
            ],
            'file_type',            
            [
                'label' => 'Link',
                'value' => function($model) {
                    return "<div style='overflow-x: auto; width: '150px'>".yii\helpers\Url::to([Yii::$app->params['mediaPathWeb'] . $model->file_name], true)."</div>";
                },
                        'format' => 'raw',
                        'contentOptions' => ['width' => '30%']
            ],
            //'created_by',
            //'updated_at',
            //'updated_by',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}','contentOptions' => ['width' => '5%']],
        ],
    ]);
    ?>


</div>
