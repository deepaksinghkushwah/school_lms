<?php

namespace app\modules\backend;

use yii;
use yii\web\Response;

class backend extends \yii\base\Module {

    public $controllerNamespace = 'app\modules\backend\controllers';

    public function init() {
        parent::init();
        if (!key_exists('Super Admin', Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))) {
            throw new \yii\web\ForbiddenHttpException('You are not authorized to perform this action.');
            return Yii::$app->getResponse()->redirect(['site/index']);
        }
        //Yii::$app->view->theme->pathMap = ['@app/views' => '@themes/admin'];
        $this->layoutPath = \Yii::getAlias('@themes/admin/views/layouts/');
        $this->layout = 'main';

        // custom initialization code goes here
    }

}
