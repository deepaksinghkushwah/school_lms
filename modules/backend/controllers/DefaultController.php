<?php

namespace app\modules\backend\controllers;

use yii\web\Controller;
use Yii;
use app\models\User;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
