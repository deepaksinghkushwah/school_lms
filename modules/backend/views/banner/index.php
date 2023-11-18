<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Banners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-index">


    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Banner', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'image' => [
                'label' => 'Image',
                'value' => function($model) {
                    return Html::img(Yii::$app->params['bannerPathWeb'] . $model->image, ['class' => 'img-thumbnail', 'width' => '100px']);
                },
                'format' => 'raw'
            ],
            'heading',
            'subheading',
            'link' => [
                'label' => 'Link',
                'format' => 'html',
                'value' => function($model) {
                    return $model->link!='' ? $model->link : 'n/a';
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
