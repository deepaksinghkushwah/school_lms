<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');
//defined('YII_ENV') or define('YII_ENV','dev');
defined('YII_ENV1') or define('YII_ENV1', 'dev');
if (YII_ENV1 == "dev") {
    $params = require(__DIR__ . '/params.php');
    $db = require(__DIR__ . '/db.php');
} elseif (YII_ENV1 == "demo") {
    $params = require(__DIR__ . '/demo_params.php');
    $db = require(__DIR__ . '/demo_db.php');
} else {
    $params = require(__DIR__ . '/live_params.php');
    $db = require(__DIR__ . '/live_db.php');
}

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];
