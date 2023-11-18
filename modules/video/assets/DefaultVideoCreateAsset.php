<?php
namespace app\modules\video\assets;

class DefaultVideoCreateAsset extends \yii\web\AssetBundle {
    public $sourcePath = '@app/modules/video/web';
    public $css = [                
        'css/style.css'
    ];
    public $js = [  
        
        'js/form.js'
        
    ];
    public $depends = [        
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
