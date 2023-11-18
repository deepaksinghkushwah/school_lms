<?php

namespace app\controllers;
use Yii;
class TestController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionMailTest() {
        \Yii::$app->mailer->compose()
                ->setTo('deepak@localhost.com')
                ->setFrom(['admin@localhost.com' => 'Admin'])
                ->setSubject('Test Email')
                ->setTextBody("This is body of page")
                ->send();
    }
    
    public function actionGetUser(){
        $roleName = Yii::$app->request->get('role');
        $users = \app\components\GeneralHelper::getUsersByRole($roleName);
        echo "<pre>";print_r($users);echo "</pre>";
        echo \yii\helpers\Html::dropDownList($roleName,'', \yii\helpers\ArrayHelper::map($users,"id","email"),['prompt' => 'Select Any']);
    }

}
