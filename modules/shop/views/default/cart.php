<?php
/* @var $this yii\web\View */
$model = \app\models\PaymentCart::findAll(['created_by' => Yii::$app->user->id]);
$subtotal = 0.00;
?>
<h1>Your Cart</h1><hr>
<table class="table table-responsive table-hover table-striped">
    <thead>
        <tr>
            <th width="10%">#</th>
            <th width="60%">Item</th>
            <th width="20%">Price</th>            
            <th width="10%"></th>
        </tr>
    </thead>   


    <?php
    if ($model) {
        ?>
        <tbody>
            <?php
            $c = 1;
            foreach ($model as $row) {
                ?>
                <tr>
                    <td><?= $c ?></td>
                    <td><?= $row->item_title ?></td>
                    <td><?= app\components\GeneralHelper::showCurrency($row->item_price); ?></td>
                    <td>
                        <a 
                            onclick="if (confirm('Are you sure want to remove this item?')) {
                                                window.location.href = '<?= yii\helpers\Url::to(['/shop/default/remove-cart-item', 'id' => $row->id], true) ?>'
                                            }"
                            href="javascript:void(0);" title="Remove item from cart">
                            <i class="glyphicon glyphicon-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php
                $subtotal += ($row->item_price * $row->item_qty);
                $c++;
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td align="right" colspan="2">Subtotal</td>
                <td><?= app\components\GeneralHelper::showCurrency($subtotal); ?></td>
                <td></td>
            </tr>
            <tr>
                <td align="right" colspan="4"><a title="Proceed to checkout" class="btn btn-primary" href="<?= yii\helpers\Url::to(['/payment/default/index'], true) ?>">Proceed To Checkout</a></td>
            </tr>
        </tfoot>
        <?php
    } else {
        ?>
        <tr>
            <td colspan="4">No item in your cart</td>
        </tr>
        <?php
    }
    ?>

</table>