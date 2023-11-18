<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PageCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Page Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-category-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Page Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'parent_id' => [
                'label' => 'Parent Category',
                'value' => function($model) {
                    $parent = \app\components\PageCategoryTree::getParentCategoriesAsString($model->id);
                    return $parent;
                },
            ],
            'title',
            'alias',
            'status',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'contentOptions' => ['width' => '70px'],
                'buttons' => [
                    'delete' => function($url, $model) {
                        $del = Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item? It will remove its child categories and related articles too!!!'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                        ]);
                        return (in_array($model->id, [1]) ? false : $del);
                    },
                            'update' => function($url, $model) {
                        $upd = Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Yii::t('yii', 'Update'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                        ]);
                        return (in_array($model->id, [1]) ? false : $upd);
                    }
                        ],
                    ],
                ],
            ]);
            ?>
</div>
