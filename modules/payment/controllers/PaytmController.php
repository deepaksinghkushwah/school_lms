<?php

namespace app\modules\payment\controllers;

use app\modules\payment\components\PaytmHelper;
use Yii;

class PaytmController extends \yii\web\Controller {

    public $enableCsrfValidation = false;

    public function actionIndex() {
        $order = \app\modules\payment\components\PaymentHelper::processPaymentStep1(Yii::$app->user->id, 2);
        return $this->render('index', ['order' => $order]);
    }

    public function actionResponse() {

        $paytmChecksum = "";
        $paramList = [];
        $isValidChecksum = "FALSE";

        $paramList = $_POST;
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
        //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
        if (Yii::$app->params['paytm']['env'] == "TEST") {
            $mKey = Yii::$app->params['paytm']['test']['PAYTM_MERCHANT_KEY'];
        } else {
            $mKey = Yii::$app->params['paytm']['live']['PAYTM_MERCHANT_KEY'];
        }

        $isValidChecksum = PaytmHelper::verifychecksum_e($paramList, $mKey, $paytmChecksum); //will return TRUE or FALSE string.

        $json = json_encode($_POST);
        $orderID = $_POST['ORDERID'];
        $order = \app\models\PaymentOrder::findOne($orderID);
        $order->gateway_response = $json;        
        if($isValidChecksum == "TRUE" && $_POST['RESPCODE'] == '01' && $_POST['STATUS'] == 'TXN_SUCCESS'){
            $order->status = 1;
        }
        $order->save(); 
        return $this->redirect(\yii\helpers\Url::to(['/payment/paytm/confirm', 'id' => $orderID]));
    }

    public function actionConfirm($id) {
        $order = \app\models\PaymentOrder::findOne(['id' => $id, 'user_id' => Yii::$app->user->id]);
        if(!$order){
            throw new \yii\web\NotFoundHttpException("Order not found",404);
        }
        return $this->render("confirm", ['order' => $order]);
    }

}
