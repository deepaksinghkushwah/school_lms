<?php

namespace app\modules\chat\assets;

/**
 * Description of DefaultIndexAsset
 *
 * @author deepak
 */
class DefaultIndexAsset extends \yii\web\AssetBundle {
    public $sourcePath = '@app/modules/chat/web';
    public $css = [                
        'css/style.css'
    ];
    public $js = [           
        'js/vue.min.js',        // production
        'https://cdn.jsdelivr.net/npm/vue/dist/vue.js',//development
        'js/index.js'
        
    ];
    public $depends = [        
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
