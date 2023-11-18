<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LmsNotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lms-notification-index">

    <h1><?= Html::encode($this->title) ?></h1><hr>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title' => [
                 'attribute' => 'title',
                'label' => 'Title',
                'value' => function($model) {
                    return $model->status == 0 ? '<b>'.$model->title.'</b>' : $model->title;
                },
                'format' => 'html'
            ],
            'message' => [
                'attribute' => 'message',
                'label' => 'Message',
                'value' => function($model) {
                    return $model->message;
                },
                'format' => 'html'
            ],
            'from_user_id' => [
                'attribute' => 'from_user_id',
                'label' => 'From',
                'value' => function($model) {
                    return app\models\Userprofile::findOne(['user_id' => $model->from_user_id])->fullname;
                }
            ],
            'status' => [
                'attribute' => 'status',
                'label' => 'Read',
                'value' => function($model) {
                    return $model->status == 0 ? 'Unread' : 'Read';
                }
            ],
            'created_at' => [
                'attribute' => 'created_at',
                'label' => 'Date',
                'value' => function($model) {
                    return date('l d M, Y H:i', strtotime($model->created_at));
                },
                'headerOptions' => ['width' => '18%']
            ],
        //'created_by',
        //'updated_at',
        //'updated_by',
        ],
    ]);
    ?>


</div>
<?php
$models = $dataProvider->getModels();
if ($models) {
    foreach ($models as $row) {
        $row->status = 1;
        $row->save();
    }
}