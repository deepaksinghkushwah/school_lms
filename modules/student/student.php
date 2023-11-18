<?php

namespace app\modules\student;

/**
 * student module definition class
 */
class student extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\student\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->layoutPath = \Yii::getAlias('@themes/frame/views/layouts/');
        $this->layout = 'main';
    }
}
