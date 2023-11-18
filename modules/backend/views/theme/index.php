<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ThemeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Themes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="theme-index">

    <p>
        <?= Html::a('Create Theme', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'filename',
            'default' => [
                'label' => 'Is Default?',
                'value' => function($model) {
                    return $model->default == 1 ? 'Yes' : 'No';
                }
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete} {default}',
                'buttons' => [
                    'default' => function($url, $model, $key) {
                        if($model->default == 1){
                            return Html::a('<i class="glyphicon glyphicon-star"></i>', \yii\helpers\Url::to(['make-default', 'id' => $model->id], true), ['title' => 'Make Default']);
                        } else {
                            return Html::a('<i class="glyphicon glyphicon-star-empty"></i>', \yii\helpers\Url::to(['make-default', 'id' => $model->id], true), ['title' => 'Make Default']);
                        }
                        
                    }
                ]
            ],
        ],
    ]);
    ?>


</div>
