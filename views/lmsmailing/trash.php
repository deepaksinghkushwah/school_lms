<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LmsMailingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trash Mail';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lms-mailing-index">

    <h1><?=$this->title;?></h1><hr>

    <p>
        <?= Html::a('Send Email', ['create'], ['class' => 'btn btn-success']) ?>


    </p>
    <div class="pull-right">
        <?= Html::a('Inbox', ['index'], ['class' => 'btn btn-primary']) ?>
        <!--<?= Html::a('Trash', ['trash'], ['class' => 'btn btn-success']) ?>-->
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'subject' => [
                'attribute' => 'subject',
                'label' => 'Subject',
                'value' => function($model) {
                    return $model->status == 0 ? '<b>' . $model->subject . '</b>' : $model->subject;
                },
                'format' => 'html'
            ],
            'from_user' => [
                'label' => 'From',
                'value' => function($model) {
                    return app\models\Userprofile::findOne(['user_id' => $model->from_user])->fullname;
                },
                'filter' => Html::dropDownList('LmsMailingSearch[from_user]', (isset($_REQUEST['LmsMailingSearch']['from_user']) ? $_REQUEST['LmsMailingSearch']['from_user'] : ''), \yii\helpers\ArrayHelper::map(app\models\Userprofile::find()->all(), "user_id", "fullname"), ['class' => 'form-control', 'prompt' => 'Select Any'])
            ],
            //'status',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view}",
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', yii\helpers\Url::to(['/lmsmailing/trash-view','id' => $model->id],true), [
                                    'title' => Yii::t('app', 'lead-view'),
                        ]);
                    },
                ],
            ],
        ],
    ]);
    ?>


</div>
