<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MediaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Media';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lms-media-index">

    
    
    <p>
        <?= Html::a('Add Media', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Add Bulk', ['bulk-upload'], ['class' => 'btn btn-success']) ?>
                <?= Html::a('Reset Search', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
    

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],            
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
                    return yii\helpers\Url::to([Yii::$app->params['mediaPathWeb'] . $model->file_name], true);
                }
            ],
            //'created_by',
            //'updated_at',
            //'updated_by',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]);
    ?>


</div>
