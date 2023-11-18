<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manage Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Export Students', ['export'], ['class' => 'btn btn-success']) ?>
        
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        /* 'filterModel' => $searchModel, */
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Image',
                'format' => 'raw',
                'value' => function($data) {
                    return Html::img(\yii\helpers\Url::to(['/images/profile/' . $data->profile->image], true), ['width' => 100, 'class' => 'img-thumbnail']);
                },
            ],
            'username',
            'email:email',
            [
                'label' => 'Role',
                'value' => function($model) {
                    return \app\components\GeneralHelper::getUserRolesByID($model->id);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'contentOptions' => ['width' => '70px'],
                'buttons' => [
                    'delete' => function($url, $model) {
                        $del = Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                        ]);
                        return (in_array($model->id, [1]) ? false : $del);
                    }
                ],
            ],
        ],
    ]);
    ?>

</div>
