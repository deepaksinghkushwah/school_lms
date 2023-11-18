<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MailingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sent Mail';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lms-mailing-index">
    <h1><?= $this->title; ?></h1><hr>
    <div class="top-mail-icon">
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', ['create'], ['class' => 'btn btn-primary','title' => 'Compose']) ?>
        <?= Html::a('<i class="fa fa-envelope" aria-hidden="true"></i>', ['index'], ['class' => 'btn btn-primary','title' => 'Inbox']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['trash'], ['class' => 'btn btn-primary','title' => 'Trash']) ?>
        <br><br>
    </div>
    <div class="listView listView-home">
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
                'label' => 'To',
                'value' => function($model) {
                    return app\models\Userprofile::findOne(['user_id' => $model->to_user])->fullname;
                },
                'filter' => Html::dropDownList('MailingSearch[to_user]', (isset($_REQUEST['MailingSearch']['to_user']) ? $_REQUEST['MailingSearch']['to_user'] : ''), \yii\helpers\ArrayHelper::map(app\models\Userprofile::find()->all(), "user_id", "fullname"), ['class' => 'form-control', 'prompt' => 'Select Any'])
            ],
//            //'status',
            'created_at' => [
                'label' => 'Sent On',
                'value' => function($model) {
                    if (date('Y-m-d', strtotime($model->created_at)) == date('Y-m-d')) {
                        return date('H:i', strtotime($model->created_at));
                    } else {
                        return date(Yii::$app->params['dateFormat'], strtotime($model->created_at));
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view}",
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', yii\helpers\Url::to(['/email/default/sent-view', 'id' => $model->id], true), [
                                    'title' => Yii::t('app', 'View'),
                        ]);
                    },
                ],
            ],
        ],
    ]);
    ?>

</div>
</div>
