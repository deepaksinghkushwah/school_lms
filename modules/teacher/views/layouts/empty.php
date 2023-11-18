<?php

use yii\helpers\Html;
\app\assets\FrameAsset::register($this);
app\components\ThemeWidget::widget();
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>

        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo Html::encode($this->title); ?></title>
        <?= Html::csrfMetaTags() ?>
        <meta property='og:site_name' content='<?php echo Html::encode($this->title); ?>' />
        <meta property='og:title' content='<?php echo Html::encode($this->title); ?>' />
        <meta property='og:description' content='<?php echo Html::encode($this->title); ?>' />        
        <?php $this->head(); ?>
        <style>
            body{
                padding: 10px;
            }
        </style>        
    </head>

    <body>
        <?php $this->beginBody(); ?>
        <?= $content ?>
        <?php $this->endBody(); ?>

    </body>
</html>
<?php $this->endPage(); ?>