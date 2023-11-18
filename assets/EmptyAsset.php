<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class EmptyAsset extends AssetBundle
{
    public $basePath = '@web/themes/frame';
    public $baseUrl = '@web';
    public $css = [
        'themes/frame/views/files/css/site.css',
        'themes/frame/views/files/css/font-awesome.css',
        '/css/bootstrap-social.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
