<?php

/* @var $this yii\web\View */
$this->title = "Orders";
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/fancybox/jquery.fancybox.min.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile(yii\helpers\BaseUrl::base() . '/js/fancybox/jquery.fancybox.min.css');
$js = "$('.fancybox').fancybox({
    iframe : {
        css : {
            width : '800px',
            height: '400px',
        }
    },
    afterClose: function () { 
        window.location.reload();
    }
});;";
$this->registerJs($js);
?>
<?=

yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id' => [
            'label' => 'Order ID',
            'attribute' => 'id',
            'value' => function($model) {
                return $model->id;
            }
        ],
        'user_id' => [
            'label' => 'Customer',
            'value' => function($model) {
                return app\models\Userprofile::findOne(['user_id' => $model->user_id])->fullname;
            }
        ],
        [
            'label' => 'Courses',
            'value' => function($model) {
                $courseList = [];
                $courses = \app\models\PaymentOrderDetail::findAll(['order_id' => $model->id]);
                if ($courses) {
                    foreach ($courses as $row) {
                        $courseList[] = app\models\LmsMasterClass::findOne($row->item_id)->title;
                    }
                }
                return implode("<br>", $courseList);
            },
            'format' => 'html'
        ],
        'total_amt' => [
            'label' => 'Order Amt',
            'format' => 'html',
            'value' => function($model) {
                return app\components\GeneralHelper::showCurrency($model->total_amt);
            }
        ],
        'gateway' => [
            'label' => 'Paid By',
            'value' => function($model) {
                switch ($model->gateway) {
                    case 0:
                        return "PayUmoney";
                        break;
                    case 1:
                        return "Offline";
                        break;
                    case 2:
                        return "Paytm";
                        break;
                }
            }
        ],
        'gateway_response' => [
            'label' => 'Comments',
            'value' => function($model) {
                $str = "";
                if ($model->gateway_response != "") {
                    $json = json_decode($model->gateway_response);
                    if ($json) {
                        $str = $json->STATUS . "<br>";
                        $str .= $json->RESPMSG . "<br>";
                    } else {
                        $str = $model->gateway_response;
                    }
                }
                return $str;
            },
            'format' => 'raw'
        ],
        'status' => [
            'label' => 'Payment Status',
            'value' => function($model) {
                return $model->status == 0 ? 'Unpaid' : 'Paid';
            }
        ],
        [
            'label' => 'Order Placed',
            'value' => function($model) {
                return date('Y-m-d H:i', strtotime($model->created_at));
            }
        ],
        [
            'label' => 'Confirm At',
            'value' => function($model) {
                if ($model->status == 1) {
                    return date('Y-m-d H:i', strtotime($model->updated_at));
                } else {
                    return "n/a";
                }
            }
        ],
        [
            'label' => 'Action',
            'format' => 'raw',
            'value' => function($model) {
                if ($model->gateway == 1 && $model->status == 0) {
                    return yii\helpers\Html::a(
                                    "Confirm Order", yii\helpers\Url::to(['/backend/order/confirm', 'id' => $model->id], true), ['fancybox', 'data-type' => 'iframe', 'class' => 'btn btn-primary fancybox']
                    );
                } else {
                    return '';
                }
            }
        ],
    //'created_by',
    //'updated_at',
    //'updated_by',
    ],
]);
?>