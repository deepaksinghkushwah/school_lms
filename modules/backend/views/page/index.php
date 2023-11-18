<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Pages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">
    <p>
        <?= Html::a('Create Page', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'alias',
            'status' => [
                'label' => 'Status',
                'value' => function($model) {
                    return $model->status == 1 ? 'Active' : 'Inactive';
                },
                        'filter' => Html::dropDownList('PageSearch[status]', (isset($_REQUEST['PageSearch']['status']) ? $_REQUEST['PageSearch']['status'] : ''), Yii::$app->params['status'],['class' => 'form-control','prompt'=> 'Select Any'])
            ],
            [
                'template' => '{update} {delete}',
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['width' => '70px'],
                'buttons' => [
                    'delete' => function($url, $model) {
                        $del = Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                        ]);
                        return (in_array($model->id, [1, 2, 3]) ? false : $del);
                    }
                ],
            ],
        ],
    ]);
    ?>

</div>
