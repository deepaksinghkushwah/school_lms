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
class AdminAsset extends AssetBundle {

    public $basePath = '@web/themes/admin';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'themes/frame/views/files/css/font-awesome.css',
        //'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
        'themes/admin/views/files/dist/css/AdminLTE.min.css',
        'themes/admin/views/files/dist/css/skins/skin-blue.min.css',
        //'https://cdn.jsdelivr.net/sweetalert2/6.4.2/sweetalert2.min.css',
        
        'themes/admin/views/files/bootstrap/css/bootstrap.min.css',
        'themes/admin/views/files/dist/css/skins/_all-skins.min.css',
    ];
    public $js = [        
        
        'themes/admin/views/files/bootstrap/js/bootstrap.min.js',
        "https://cdn.jsdelivr.net/npm/sweetalert2@9",
        //'https://cdn.jsdelivr.net/sweetalert2/6.4.2/sweetalert2.min.js',
//        'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
//        'themes/admin/views/files/plugins/morris/morris.min.js',
//        'themes/admin/views/files/plugins/sparkline/jquery.sparkline.min.js',
//        'themes/admin/views/files/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
//        'themes/admin/views/files/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
//        'themes/admin/views/files/plugins/knob/jquery.knob.js',
//        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js',
//        'themes/admin/views/files/plugins/daterangepicker/daterangepicker.js',
//        'themes/admin/views/files/plugins/datepicker/bootstrap-datepicker.js',
//        'themes/admin/views/files/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
//        'themes/admin/views/files/plugins/slimScroll/jquery.slimscroll.min.js',
//        'themes/admin/views/files/plugins/fastclick/fastclick.js',
        
        'themes/admin/views/files/dist/js/demo.js',
        'themes/admin/views/files/dist/js/app.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
