<?php

namespace app\modules\payment\controllers;

use Yii;

class PayumoneyController extends \yii\web\Controller {

    public function actionIndex() {        
        $order = \app\modules\payment\components\PaymentHelper::processPaymentStep1(Yii::$app->user->id, 0);   
        return $this->render('index', ['id' => $order->id]);
    }

    public function actionResponse() {
        return $this->render("response");
    }

    public function actionConfirm() {
        return $this->render("confirm");
    }

}
