<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LmsMailingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inbox';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lms-mailing-index">
    <h1><?= $this->title ?></h1><hr>
    <div class="top-mail-icon">
        <?= Html::a('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', ['create'], ['class' => 'btn btn-primary','title' => 'Compose']) ?>
        <?= Html::a('<i class="fa fa-paper-plane" aria-hidden="true"></i>', ['sent'], ['class' => 'btn btn-primary','title' => 'Send Items']) ?>
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['trash'], ['class' => 'btn btn-primary','title' => 'Trash']) ?>
        <br><br>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="listView listView-home">
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
                        $val = $model->status == 0 ? '<strong>' . $model->subject . '</strong>' : $model->subject;
                        return yii\bootstrap\Html::a($val, yii\helpers\Url::to(['/email/default/view', 'id' => $model->id], true));
                    },
                    'format' => 'html'
                ],
                'from_user' => [
                    'label' => 'From',
                    'value' => function($model) {
                        return app\models\Userprofile::findOne(['user_id' => $model->from_user])->fullname;
                    },
                    'filter' => Html::dropDownList('MailingSearch[from_user]', (isset($_REQUEST['MailingSearch']['from_user']) ? $_REQUEST['MailingSearch']['from_user'] : ''), \yii\helpers\ArrayHelper::map(app\models\Userprofile::find()->all(), "user_id", "fullname"), ['class' => 'form-control', 'prompt' => 'Select Any'])
                ],
                'created_at' => [
                    'label' => 'Received On',
                    'value' => function($model) {
                        if (date('Y-m-d', strtotime($model->created_at)) == date('Y-m-d')) {
                            return date('H:i', strtotime($model->created_at));
                        } else {
                            return date(Yii::$app->params['dateFormat'], strtotime($model->created_at));
                        }
                    }
                ],
                //'status',
                ['class' => 'yii\grid\ActionColumn', 'template' => "{view} {delete}"],
            ],
        ]);
        ?>
    </div>
</div>
