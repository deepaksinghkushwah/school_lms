<?php

namespace app\modules\payment\assets;

/**
 * Description of DefaultIndexAsset
 *
 * @author deepak
 */
class PayUMontyIndexAsset extends \yii\web\AssetBundle {
    public $sourcePath = '@app/modules/payment/web';
    public $css = [                
        'css/style.css'
    ];
    public $js = [        
        'js/index.js'
        
    ];
    public $depends = [        
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
