<?php

namespace app\components;

/**
 * This widget will display banner on pages.
 *
 * @author Deepak Singh Kushwah
 */
class BannerWidget extends \yii\base\Widget {

    public function init() {
        parent::init();
    }
    
    public function run(){
        $model = \app\models\Banner::findAll(['status' => 1]);
        return $this->render('banner.php', ['model' => $model]);
    }

}
