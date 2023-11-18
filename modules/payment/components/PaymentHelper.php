<?php

namespace app\modules\payment\components;

use Yii;

class PaymentHelper {

    /**
     * 
     * @param int $userID
     * @param int $paymentGateway
     * @return \app\models\PaymentOrder
     */
    public static function processPaymentStep1($userID, $paymentGateway = 0) {
        // create order
        $order = new \app\models\PaymentOrder();
        $order->total_amt = \app\modules\shop\components\ShopHelper::getCartTotal($userID);
        $order->user_id = $userID;
        $order->status = 0;
        $order->gateway = $paymentGateway;
        $order->gateway_response = "";
        $order->save();
        // fill order detail
        $cart = \app\models\PaymentCart::findAll(['created_by' => $userID]);
        if ($cart) {
            foreach ($cart as $row) {
                $orderDetail = new \app\models\PaymentOrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->item_id = $row->item_id;
                $orderDetail->item_title = $row->item_title;
                $orderDetail->item_price = $row->item_price;
                $orderDetail->item_type = 1;
                $orderDetail->item_qty = $row->item_qty;
                $orderDetail->total_amt = $row->item_qty * $row->item_price;
                $orderDetail->save();
            }
        }
        // empty cart
        \app\models\PaymentCart::deleteAll(['created_by' => $userID]);
        switch ($paymentGateway) {
            case 0: // payumoney
                break;
            case 1: // offline
                self::sendOrderConfirmMail($order);
                break;
            case 2: // paytm
                //self::sendOrderConfirmMail($order);
                break;
        }
        return $order;
    }

    /**
     * @param app\models\PaymentOrder $order
     * @return type
     */
    public static function sendOrderConfirmMail($order) {
        $userProfile = \app\models\Userprofile::findOne(['user_id' => $order->user_id]);
        $email = $userProfile->user->email;


        $mail = Yii::$app->mailer->compose(['html' => 'orderconfirm'], [
            'userprofile' => $userProfile,
            'order' => $order
        ]);

        $sub = "Order Confirm: #" . $order->id;
        $mail->setTo($userProfile->user->email);
        $mail->setFrom(Yii::$app->params['settings']['admin_email']);
        $mail->setSubject($sub);
        $data = $mail->send();
    }

}
