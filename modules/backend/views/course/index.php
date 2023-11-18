<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LmsMasterClassSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lms-master-class-index">

    

    <p>
        <?= Html::a('Create Course', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'price' => [
                'label' => 'Price',
                'value' => function($model) {
                    return app\components\GeneralHelper::showCurrency($model->price);
                },
                'format' => 'raw',
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => "{update} {delete}"],
        ],
    ]);
    ?>


</div>
