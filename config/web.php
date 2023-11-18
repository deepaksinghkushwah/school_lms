<?php

use kartik\mpdf\Pdf;

Yii::setAlias('@themes', dirname(__DIR__) . '/web/themes');

$config = [
    'id' => 'school',
    'name' => 'School Manager',
    'timeZone' => 'Asia/Kolkata',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'bootstrap' => ['app\components\Settings'],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'menus' => [
                /* 'assignment' => [
                  'label' => 'Grand Access' // change label
                  ], */
                'route' => null, // disable menu route
            ]
        ],
        'chat' => [
            'class' => 'app\modules\chat\chat',
        ],
        'backend' => [
            'class' => 'app\modules\backend\backend',
        ],
        'student' => [
            'class' => 'app\modules\student\student',
        ],
        'teacher' => [
            'class' => 'app\modules\teacher\teacher',
        ],
        'shop' => [
            'class' => 'app\modules\shop\shop',
        ],
        'payment' => [
            'class' => 'app\modules\payment\payment',
        ],
        'video' => [
            'class' => 'app\modules\video\video',
        ],
        'email' => [
            'class' => 'app\modules\email\mail',
        ],
    ],
    'components' => [
        'pdf' => [
            'class' => Pdf::class,
            'format' => Pdf::FORMAT_LETTER,
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'destination' => Pdf::DEST_DOWNLOAD,
        // refer settings section for all configuration options
        ],
        'assetManager' => [
            /* 'bundles' => [
              'yii\web\JqueryAsset' => [
              'js' => []
              ],
              'yii\bootstrap\BootstrapPluginAsset' => [
              'js' => []
              ],
              'yii\bootstrap\BootstrapAsset' => [
              'css' => [],
              ],
              ], */
            'linkAssets' => true,
            'appendTimestamp' => true,
        ],
        // do not use session from DB, it's bug in yii2.0.14, it will slow the page, very slow
        /* 'session' => [
          'class' => 'yii\web\DbSession',
          // Set the following if you want to use DB component other than
          // default 'db'.
          // 'db' => 'mydb',
          // To override default session table, set the following
          // 'sessionTable' => 'my_session',
          ], */
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@themes/frame/views',
                    '@app/modules' => '@themes/admin',
                    'baseUrl' => '@public_html',
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '4yJxvTfgBd7GEeGe3FJqt7Z24Lh9p1Pq',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/news' => 'site/news',
                '/contact' => 'site/contact',
                '/signup' => 'site/signup',
                '/login' => 'site/login',
                '/logout' => 'site/logout',
                '/static/<alias>' => 'site/page',
            /* '<category:\w+>/<subcategory:\w+>/<alias>' => 'site/page',
              '<category:\w+>/<subcategory:\w+>/<sub2category:\w+>/<alias>' => 'site/page',
              '<category:\w+>/<subcategory:\w+>/<sub2category:\w+>/<sub3category:\w+>/<alias>' => 'site/page',
              '<category:\w+>/<subcategory:\w+>/<sub2category:\w+>/<sub3category:\w+>/<sub4category:\w+>/<alias>' => 'site/page',
              '<category:\w+>/<subcategory:\w+>/<sub2category:\w+>/<sub3category:\w+>/<sub4category:\w+>/<sub5category:\w+>/<alias>' => 'site/page', */
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'container' => [
        'definitions' => [
            'yii\widgets\LinkPager' => [
                'firstPageLabel' => 'First',
                'lastPageLabel' => 'Last'
            ]
        ]
    ],
    'params' => require(__DIR__ . '/params.php'),
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*', // add or remove allowed actions to this list            
            'debug/*',
        ]
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    //$config['bootstrap'][] = 'debug';
    //$config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';

    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
    $config['components']['assetManager']['forceCopy'] = true;

    $config['components']['mailer'] = require(__DIR__ . '/mailer.php');
    $config['components']['db'] = require(__DIR__ . '/db.php');

    $config['components']['reCaptcha'] = require(__DIR__ . '/recaptcha.php');
} else {
    $config['components']['mailer'] = require(__DIR__ . '/live_mailer.php');
    $config['components']['db'] = require(__DIR__ . '/live_db.php');
    $config['components']['reCaptcha'] = require(__DIR__ . '/live_recaptcha.php');
}

return $config;
