<?php
/* @var $this yii\web\View */



$this->title = "Order Status";
?>
<h1><?= $this->title ?></h1><hr>
<?php

$json = json_decode($order->gateway_response);
if($json->STATUS == 'TXN_SUCCESS' && $json->RESPCODE == '01'){
    echo "Your order has been confirmed and course added to your courses section. Please click <a href='".yii\helpers\Url::to(['/student/default/index'],true)."'>here</a> to goto course.";
} else {
    echo $json->RESPMSG;
}
/*foreach ($json as $key => $param) {
    if (in_array($key, ['MID', 'CHECKSUMHASH', 'BANKTXNID'])) {
        continue;
    } else {
        echo $key . " => " . $param . "<br>";
    }
}*/
?>