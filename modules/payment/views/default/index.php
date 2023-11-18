<?php
$this->title = "Select Payment Gateway";
?>
<div class="payment-default-index">
    <h1><?= $this->title ?></h1>
    <ul>
        <!--<li><a href="<?= yii\helpers\Url::to(['/payment/payumoney/index'],true)?>">PayUmoney</a></li>-->
        <li><a href="<?= yii\helpers\Url::to(['/payment/offline/index'],true)?>">Offline</a></li>
        <li><a href="<?= yii\helpers\Url::to(['/payment/paytm/index'],true)?>">Paytm</a></li>
    </ul>
</div>
