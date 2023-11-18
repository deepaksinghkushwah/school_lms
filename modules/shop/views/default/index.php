<?php
/* @var $this yii\web\View */
$this->title = "Purchase Course"
?>
<div class="shop-default-index">
    <h1><?= $this->title; ?></h1><hr>
    <div class="row">
        <?php
        if ($model) {
            $c = 0;
            foreach ($model as $row) {
                ?>

                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-5"><?= $row->title; ?></div>
                                <div class="col-md-3">Price: <?=app\components\GeneralHelper::showCurrency($row->price);?></div>
                                <div class="col-md-4">
                                    <a class="btn btn-primary" href="<?= yii\helpers\Url::to(['/shop/default/add-to-cart', 'id' => $row->id], true) ?>">
                                        <i class="glyphicon glyphicon-shopping-cart"></i> Add To Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                $c++;
                if($c % 2 == 0){
                    echo "</div><div class='row'>";
                }
            }
        }
        ?>
    </div>
</div>
