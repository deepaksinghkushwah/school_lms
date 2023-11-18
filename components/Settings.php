<?php

namespace app\components;

use yii;

class Settings implements yii\base\BootstrapInterface {

    private $db;

    public function __construct() {
        $this->db = \Yii::$app->db;
    }

    public function bootstrap($app) {
        // Get settings from database
        $sql = $this->db->createCommand("SELECT `key`,`value` FROM setting");
        $settings = $sql->queryAll();

        // Now let's load the settings into the global params array

        foreach ($settings as $key => $val) {
            Yii::$app->params['settings'][$val['key']] = $val['value'];
        }
    }

}
