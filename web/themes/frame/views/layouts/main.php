<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\debug\Toolbar;

\app\assets\FrameAsset::register($this);
\app\components\ThemeWidget::widget();
$mainDivWidth = 12;
$leftDivWidth = 0;
$rightDivWidth = 0;
$leftMenu = \app\models\Menu::findOne(['location' => 'left', 'status' => 1]);
$rightMenu = \app\models\Menu::findOne(['location' => 'right', 'status' => 1]);
if ($leftMenu && !$rightMenu) {
    $mainDivWidth = 10;
    $leftDivWidth = 2;
} elseif ($rightMenu && !$leftMenu) {
    $mainDivWidth = 10;
    $rightDivWidth = 2;
} elseif ($leftMenu && $rightMenu) {
    $mainDivWidth = 8;
    $leftDivWidth = 2;
    $rightDivWidth = 2;
} else {
    $mainDivWidth = 12;
    $leftDivWidth = 0;
    $rightDivWidth = 0;
}
$title = strpos($this->title, Yii::$app->params['settings']['application_name']) === FALSE ? (Yii::$app->params['settings']['application_name'] . ' - ' . Html::encode($this->title)) : Html::encode($this->title);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo Html::encode($title); ?></title>
        <?= Html::csrfMetaTags() ?>
        <meta property='og:site_name' content='<?php echo Html::encode($this->title); ?>' />
        <meta property='og:title' content='<?php echo Html::encode($this->title); ?>' />
        <meta property='og:description' content='<?php echo Html::encode($this->title); ?>' />


        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php $this->head(); ?>        


    </head>

    <body>
        <?php $this->beginBody(); ?>

        <?php include(dirname(__FILE__) . '/menu.php'); ?>
        <div class="<?= $leftMenu || $rightMenu ? 'container-fluid' : 'container' ?>">
            <div class="row">
                <?= $leftMenu ? '<div class="col-xs-' . $leftDivWidth . '">' . \app\components\MenuWidget::widget(['location' => 'left']) . '</div>' : ''; ?>

                <div class="col-xs-<?= $mainDivWidth ?>">
                    <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message) { ?>
                        <div class="alert alert-<?php echo $key; ?> ">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php
                            if (is_array($message)) {
                                foreach ($message as $row) {
                                    echo $row . "<Br/>";
                                }
                            } else {
                                echo $message;
                            }
                            ?>                            

                        </div>
                        <?php
                    }
                    ?>
                    <?php echo $content; ?>
                </div>
                <?= $rightMenu ? '<div class="col-md-' . $rightDivWidth . '">' . \app\components\MenuWidget::widget(['location' => 'right']) . '</div>' : ''; ?>
            </div>

        </div>

        <?php
        $footMenu = \app\models\Menu::findOne(['location' => 'bottom', 'status' => 1]);
        if ($footMenu) {
            ?>
            <div class="<?= $leftMenu || $rightMenu ? 'container-fluid' : 'container' ?>">
                <div class="row bg-info well">
                    <?= \app\components\MenuWidget::widget(['location' => 'bottom','bottomMenuWidth' => ($leftMenu || $rightMenu ? 3 : 4)]); ?>
                </div>
            </div>

            <?php
        }
        ?>

        <footer class="footer">

            <div class="container">
                &copy; <?= Yii::$app->params['settings']['application_name']; ?> <?= date('Y') ?>    
                <div class="pull-right">
                    <?= Html::a('Privacy & Policy', \yii\helpers\Url::to(['/static/privacy-policy'], true)); ?>
                    | <?= Html::a('Terms & Conditions', \yii\helpers\Url::to(['/static/terms-and-conditions'], true)); ?>
                    | Powered By: YII v<?= Yii::getVersion(); ?>
                </div>
            </div>


        </footer>
        <?php $this->endBody(); ?>

    </body>
</html>
<?php $this->endPage(); ?>