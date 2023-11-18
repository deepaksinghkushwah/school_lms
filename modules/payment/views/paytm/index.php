<?php
/* @var $this yii\web\View */
/* @var $order \app\models\PaymentOrder */

use app\modules\payment\components\PaytmHelper;

$this->title = "Paytm Payment Processing...";
$checkSum = "";
$paramList = array();

/* $ORDER_ID =random_int(2, 20000);
  $CUST_ID = random_int(2, 20000);
  $INDUSTRY_TYPE_ID = 'Retail';
  $CHANNEL_ID = 'WEB';
  $TXN_AMOUNT = random_int(2, 200); */

// Create an array having all required parameters for creating checksum.

$paramList["ORDER_ID"] = $order->id;
$paramList["CUST_ID"] = Yii::$app->user->id;
$paramList["INDUSTRY_TYPE_ID"] = 'Retail';
$paramList["CHANNEL_ID"] = 'WEB';
$paramList["TXN_AMOUNT"] = number_format($order->total_amt,2,".","");
$paramList["CALLBACK_URL"] = \yii\helpers\Url::to(['/payment/paytm/response'], true);


//Here checksum string will return by getChecksumFromArray() function.

if (Yii::$app->params['paytm']['env'] == "TEST") {
    $paramList["MID"] = Yii::$app->params['paytm']['test']['PAYTM_MERCHANT_MID'];
    $paramList["WEBSITE"] = Yii::$app->params['paytm']['test']['PAYTM_MERCHANT_WEBSITE'];
    $txnUrl = Yii::$app->params['paytm']['test']['PAYTM_TXN_URL'];
    $checkSum = PaytmHelper::getChecksumFromArray($paramList, Yii::$app->params['paytm']['test']['PAYTM_MERCHANT_KEY']);
} else {
    $paramList["MID"] = Yii::$app->params['paytm']['live']['PAYTM_MERCHANT_MID'];
    $paramList["WEBSITE"] = Yii::$app->params['paytm']['live']['PAYTM_MERCHANT_WEBSITE'];
    $txnUrl = Yii::$app->params['paytm']['live']['PAYTM_TXN_URL'];
    $checkSum = PaytmHelper::getChecksumFromArray($paramList, Yii::$app->params['paytm']['live']['PAYTM_MERCHANT_KEY']);
}

?>
<center><h1>Please do not refresh this page...</h1></center>
<form method="post" action="<?php echo $txnUrl ?>" name="f1">
    <table border="1">
        <tbody>
            <?php
            foreach ($paramList as $name => $value) {
                echo '<input type="hidden" name="' . $name . '" value="' . $value . '">';
            }
            ?>
        <input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
        </tbody>
    </table>
</form>
<?php
$this->registerJs("document.f1.submit();");
