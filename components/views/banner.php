<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php
        $c = 0;
        foreach ($model as $row) {
            ?>
            <li data-target="#carousel-example-generic" data-slide-to="<?= $c ?>" class="<?= $c == 0 ? 'active' : ''; ?>"></li>
            <?php
            $c++;
        }
        ?>        
    </ol>

    <!-- Wrapper for slides -->

    <div class="carousel-inner" role="listbox">
        <?php
        $c = 0;
        foreach ($model as $row) {
            ?>
            <div class="item <?=$c==0 ? 'active' : '';?>">
                <img class="img-responsive" src="<?= yii\helpers\Url::to([Yii::$app->params['bannerPathWeb'] . $row->image], true); ?>" alt="" class="img-responsive">
                <div class="carousel-caption">
                    <?= $row->heading; ?>
                    <?= $row->subheading; ?>
                </div>
            </div>
            <?php
            $c++;
        }
        ?>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>