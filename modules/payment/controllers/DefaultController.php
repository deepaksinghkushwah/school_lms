<?php

namespace app\modules\payment\controllers;

use yii\web\Controller;
use Yii;
/**
 * Payumoney controller for the `payment` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {        
        return $this->render('index');
    }
}
