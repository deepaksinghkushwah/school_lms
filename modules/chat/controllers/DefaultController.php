<?php

namespace app\modules\chat\controllers;

use yii\web\Controller;
use Yii;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */

    //public $layout = "empty";
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionGetMessageList() {
        $toUserID = Yii::$app->request->get('to_user');
        $sql = "SELECT * FROM `chat` WHERE "
                . "(to_user_id = '".$toUserID."' AND created_by = '" . Yii::$app->user->id . "') OR "
                . "(to_user_id = '".Yii::$app->user->id."' AND created_by = '" . $toUserID . "') order by id asc";
        $rows = Yii::$app->db->createCommand($sql)->queryAll();
        $msg = [];
        if ($rows) {
            foreach ($rows as $row) {
                $msg[] = [
                    'id' => $row['id'],
                    'to' => \app\models\Userprofile::findOne(['user_id' => $row['to_user_id']])->fullname,
                    'to_user_id' => $row['to_user_id'],
                    'message' => $row['message'],
                    'from' => \app\models\Userprofile::findOne(['user_id' => $row['created_by']])->fullname,
                    'created_at' => (date('Y-m-d')== date('Y-m-d',strtotime($row['created_at'])) ? date('H:i:s a',strtotime($row['created_at'])) : date('jS M Y H:i:s a',strtotime($row['created_at'])))
                ];
            }
        }
        sleep(3);
        return json_encode($msg);
    }

    public function actionSaveMessage() {
        $toUserID = Yii::$app->request->get('to_user');
        $message = Yii::$app->request->get('message');
        $model = new \app\modules\chat\models\Chat();
        $model->to_user_id = $toUserID;
        $model->message = $message;
        $model->status = 1;
        if ($model->save()) {
            return json_encode(['status' => 1, 'code' => "Message saved"]);
        } else {
            return json_encode(['error' => \app\components\GeneralHelper::getErrorAsString($model)]);
        }
    }

}
