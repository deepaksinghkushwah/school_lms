<?php

namespace app\modules\shop\components;
use Yii;
class ShopHelper {

    public static function getCartTotal($userID) {
        $total = 0.00;
        $cart = \app\models\PaymentCart::findAll(['created_by' => $userID]);
        if ($cart) {
            foreach ($cart as $row) {
                $total += $row->item_price * $row->item_qty;
            }
        }

        return $total;
    }
    
    public static function checkStudentOwnCourse($userID, $courseID){
        $sql = "SELECT "
                . "pod.*, "
                . "po.`status` "
                . "FROM payment_order_detail pod "
                . "LEFT JOIN payment_order po ON po.`id` = pod.`order_id` "
                . "WHERE  "
                . "pod.order_id = po.id "
                . "AND pod.item_id = $courseID "
                . "AND po.`user_id` = $userID "
                . "AND po.`status` =  1;";
        $row = Yii::$app->db->createCommand($sql)->queryOne();
        if($row){
            return true;
        } else {
            return false;
        }
    }

}
