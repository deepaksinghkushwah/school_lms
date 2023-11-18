<?php

namespace app\modules\payment\controllers;
use Yii;
class OfflineController extends \yii\web\Controller
{
    public function actionIndex()
    {        
        
        $order = \app\modules\payment\components\PaymentHelper::processPaymentStep1(Yii::$app->user->id, 1);   
        return $this->redirect(\yii\helpers\Url::to(['/payment/offline/success','order_id' => $order->id],true));
    }
    
    public function actionSuccess(){
        return $this->render('success',['orderID' => Yii::$app->request->get('order_id')]);
    }

}
