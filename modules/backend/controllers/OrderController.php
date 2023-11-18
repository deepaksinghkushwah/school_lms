<?php

namespace app\modules\backend\controllers;

use Yii;

class OrderController extends \yii\web\Controller {

    public function actionIndex() {
        $searchModel = new \app\models\PaymentOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
        return $this->render('index');
    }

    public function actionConfirm() {
        $this->layout = "empty";
        $orderID = Yii::$app->request->get('id');
        $model = \app\models\PaymentOrder::findOne($orderID);
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 1;
            $model->save();
            Yii::$app->session->setFlash("success", "Order confirmed");
            return $this->refresh();
        }
        return $this->render('confirm', ['model' => $model]);
    }

}
