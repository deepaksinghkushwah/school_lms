
School Manager
============================

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7.3.x


INSTALLATION
------------

Just clone on your desktop and setup your database. There is database folder on root and use latest database sql file to import. Browse url.
then run migraton


After migraton, run "composer update -vvv" command because I have removed vendor folder, so run it on your end to get latest vendor files.

Once above tasks done, please update your local/demo/live server details in config folder file.

Login users/pass
----------
1. super user: admin/123456
2. normal users
	1. test1/123456
	2. test2/123456
				
Rigth now all users have same password 123456.
---------------------------

Note: Please create following folders on your local copy as they are ignored in committing to github (if folders are not there)

- /runtime/
- /web/assets/
- /web/cache/

Developer also need to create following files with provided content because these files are in ignore list due to customize setup on each server
-------------------------------------------------------------------------------------------------------------------------------------------------
1. ./config/console.php
```php
    <?php
    Yii::setAlias('@tests', dirname(__DIR__) . '/tests');
    //defined('YII_ENV') or define('YII_ENV','dev');
    defined('YII_ENV1') or define('YII_ENV1','dev');
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

```

2. ./public_html/index.php
```php
    <?php
    // comment out the following two lines when deployed to production
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    //exit($_SERVER['HTTP_HOST']);
    switch ($_SERVER['HTTP_HOST']) {    
        case 'school.local':
            defined('YII_ENV') or define('YII_ENV', 'dev');        
            break;
        default:
            defined('YII_ENV') or define('YII_ENV', 'live');
            break;
    }
    require(__DIR__ . '/../vendor/autoload.php');
    require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

    $config = require(__DIR__ . '/../config/web.php');

    (new yii\web\Application($config))->run();
```


3. ./public_html/index-test.php
```php
    <?php

    // NOTE: Make sure this file is not accessible when deployed to production
    if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
        die('You are not allowed to access this file.');
    }

    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'test');

    require(__DIR__ . '/../vendor/autoload.php');
    require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

    $config = require(__DIR__ . '/../tests/codeception/config/acceptance.php');

    (new yii\web\Application($config))->run();
```
4. ./public_html/.htaccess
```htaccess
    RewriteEngine on
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d

    RewriteRule . index.php
    php_flag display_errors on
    php_flag log_errors on
    php_value error_log ./error.log
    <ifModule mod_deflate.c>
            AddOutputFilterByType DEFLATE text/text text/html text/plain text/xml text/css application/x-javascript application/javascript
    </ifModule>     
```

----------------------------

This project has MDMSoft RBAC user rights management tool. A small page manager, user creator section is also included in this setup.

Urls
------
1. Backend Url: /backend/default/index
You can see backend if you are logged in usign admin user details.

2. User Rights: /admin/assignment 
You can see and set user rights and various roles for a user. You can find documents for this section right here (Yii2 Admin)[https://github.com/mdmsoft/yii2-admin]

3. After login via admin user, there is top navigation menu which hold  all links which user has access to. Please login on the project login page and see the options.

Page Manager At Backend
------------------------
Page manager has 3 categories right now
1. System - This category contains only system pages like about us, privacy policy etc. These pages can not be deleted.
2. General - General category contains normal pages which we need to show on website.
3. News - News pages will be shows in latest news section (on frontpage at top navigation)

Manage Comments: Page manager also hold a menu "Manage Comments", this section will show all commentes received on news pages or other pages which has allowed comments system. Admin can manage all pages comments in this section.


User Manager At Admin End
-------------------------
Admin has rigth to create new users from control panel. You can list all users or create new user from left panel.


General Settings
---------------- 
General setting hold basic settings you can modify like pages par page, admin or support email.
