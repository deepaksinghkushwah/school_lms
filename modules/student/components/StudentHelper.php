<?php

namespace app\modules\student\components;

use Yii;

class StudentHelper {

    public static function getStudentCourses($userID) {
        $courses = [];
        if (Yii::$app->user->can("Teacher")) {
            $c = \app\models\LmsMasterClass::find()->orderBy(['id' => SORT_ASC])->all();
            foreach($c as $row){
                $courses[] = ['id' => $row->id, 'title' => $row->title];
            }
        } else {
            $orders = \app\models\PaymentOrder::findAll(['user_id' => $userID, 'status' => 1]);
            if ($orders) {
                foreach ($orders as $o) {
                    $od = \app\models\PaymentOrderDetail::findAll(['order_id' => $o->id]);
                    if ($od) {
                        foreach ($od as $orderDetail) {
                            $courses[] = ['id' => $orderDetail->item_id, 'title' => $orderDetail->item_title];
                        }
                    }
                }
            }
        }
        asort($courses);
        return $courses;
    }

    public static function checkCourseOwnership($userID, $courseID) {
        if (Yii::$app->user->can("Teacher")) {
            return true;
        }
        //$sql = "SELECT * FROM payment_order_detail WHERE order_id IN (SELECT id FROM payment_order WHERE user_id = '".$userID.") AND item_id = '$courseID'";
        $sql = "SELECT pod.*, po.`status` FROM payment_order_detail pod LEFT JOIN payment_order po ON po.`id` = pod.`order_id` WHERE  pod.order_id = po.id AND pod.item_id = $courseID AND po.`user_id` = $userID AND po.`status` =  1";
        $item = Yii::$app->db->createCommand($sql)->queryScalar();
        if ($item) {
            return true;
        } else {
            Yii::$app->session->setFlash("danger", "You are not authorized to view this course or it's content");
            return Yii::$app->response->redirect(\yii\helpers\Url::to(['/student/default/index'], true));
        }
    }

}
