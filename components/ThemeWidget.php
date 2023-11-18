<?php

namespace app\components;

/**
 * This widget will display banner on pages.
 *
 * @author Deepak Singh Kushwah
 */
use Yii;

class ThemeWidget extends \yii\base\Widget {

    public function init() {
        parent::init();
    }

    public function run() {
        $model = \app\models\Theme::findOne(['default' => 1]);
        if ($model) {
            Yii::$app->view->registerCssFile(\yii\helpers\Url::to([Yii::$app->params['themePathWeb'] . $model->filename],true), [
                'depends' => [\yii\bootstrap\BootstrapAsset::class],                
            ]);
        }
    }

}
