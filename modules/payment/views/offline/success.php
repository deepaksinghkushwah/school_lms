<?php
/* @var $this yii\web\View */
$this->title = "Order confirm";
?>
<h1><?=$this->title?></h1>
<p>Your order[#<?=$orderID?>] has been confirm, please wait for payment process as you have chooses offline payment. Our support team will contact you soon.</p>
<a href="<?= yii\helpers\Url::to(['/shop/default/index'],TRUE)?>">Continue</a> your learning