<?php
/* @var $this yii\web\View */
app\modules\payment\assets\PayUMontyIndexAsset::register($this);
if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0) {
    //Request hash
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if (strcasecmp($contentType, 'application/json') == 0) {
        $data = json_decode(file_get_contents('php://input'));
        $hash = hash('sha512', $data->key . '|' . $data->txnid . '|' . $data->amount . '|' . $data->pinfo . '|' . $data->fname . '|' . $data->email . '|||||' . $data->udf5 . '||||||' . $data->salt);
        $json = array();
        $json['success'] = $hash;
        echo json_encode($json);
    }
    exit(0);
}

function getCallbackUrl() {
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . 'response.php';
}

// Test site 
$this->registerJsFile('https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js', [
    'position' => $this::POS_HEAD,
    'id' => 'bolt',
    'bolt-color' => "e34524",
    'bolt-logo' => 'http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png,'
]);

// Live site
/*
  $this->registerJsFile('https://checkout-static.citruspay.com/bolt/run/bolt.min.js',[
  'id' => 'bolt',
  'bolt-color' => "e34524",
  'bolt-logo' => 'http://boltiswatching.com/wp-content/uploads/2015/09/Bolt-Logo-e14421724859591.png,'
  ]);
 */
echo \yii\helpers\Html::hiddenInput("mainUrl", yii\helpers\Url::to(['/payment/payumoney/index'],true),['id' => 'mainUrl']);
?>
<div class="main">
    <div>
        <img src="<?= yii\helpers\Url::to(['/images/payumoney.png'],true)?>" />
    </div>
    <div>
        <h3>PHP7 BOLT Kit</h3>
    </div>
    <?= \yii\helpers\Html::beginForm("#", 'post', ['id' => 'payment_form']) ?>

    <input type="hidden" id="udf5" name="udf5" value="BOLT_KIT_PHP7" />
    <input type="hidden" id="surl" name="surl" value="<?php echo getCallbackUrl(); ?>" />
    <div class="dv">
        <span class="text"><label>Merchant Key:</label></span>
        <span><input type="text" id="key" name="key" placeholder="Merchant Key" value="<?=Yii::$app->params['payUMoney']['merchantKey']?>" /></span>
    </div>

    <div class="dv">
        <span class="text"><label>Merchant Salt:</label></span>
        <span><input type="text" id="salt" name="salt" placeholder="Merchant Salt" value="<?=Yii::$app->params['payUMoney']['merchantSalt']?>" /></span>
    </div>

    <div class="dv">
        <span class="text"><label>Transaction/Order ID:</label></span>
        <span><input type="text" id="txnid" name="txnid" placeholder="Transaction ID" value="<?php echo "Txn" . rand(10000, 99999999) ?>" /></span>
    </div>

    <div class="dv">
        <span class="text"><label>Amount:</label></span>
        <span><input type="text" id="amount" name="amount" placeholder="Amount" value="6.00" /></span>    
    </div>

    <div class="dv">
        <span class="text"><label>Product Info:</label></span>
        <span><input type="text" id="pinfo" name="pinfo" placeholder="Product Info" value="P01,P02" /></span>
    </div>

    <div class="dv">
        <span class="text"><label>First Name:</label></span>
        <span><input type="text" id="fname" name="fname" placeholder="First Name" value="Deepak" /></span>
    </div>

    <div class="dv">
        <span class="text"><label>Email ID:</label></span>
        <span><input type="text" id="email" name="email" placeholder="Email ID" value="deepaksinghkushwah@gmail.com" /></span>
    </div>

    <div class="dv">
        <span class="text"><label>Mobile/Cell Number:</label></span>
        <span><input type="text" id="mobile" name="mobile" placeholder="Mobile/Cell Number" value="8233142631" /></span>
    </div>

    <div class="dv">
        <span class="text"><label>Hash:</label></span>
        <span><input type="text" id="hash" name="hash" placeholder="Hash" value="" /></span>
    </div>


    <div><input type="submit" value="Pay" onclick="launchBOLT(); return false;" /></div>
    <?= \yii\helpers\Html::endForm(); ?>
</div>