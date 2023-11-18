<?php

use yii\helpers\Html;
use yii\helpers\Url;
use \yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
$this->title= "Bulk Upload Images";
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/dropzone/dropzone.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/backend/media/upload.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile(yii\helpers\BaseUrl::base() . '/js/dropzone/dropzone.css');
$this->registerCssFile(yii\helpers\BaseUrl::base() . '/js/dropzone/basic.css');
?>




<div class="media-form">    
    <p><a href="<?= Url::to(['/backend/media/index'],true)?>" class="btn btn-primary">Back to media</a></p>
   <?php
    echo Html::beginForm(yii\helpers\Url::to(['/backend/media/bulk-upload-process'], true), 'post', [
        'enctype' => 'multipart/form-data',
        'class' => 'dropzone',
        'id' => 'myAwesomeDropzone',
    ]);
    //echo Html::hiddenInput("product_id", $productId);
    ?>

    <div class="fallback">
        <?= Html::fileInput('file', '', ['accept' => 'image/*']); ?>
    </div>

    <?php echo Html::endForm(); ?>

</div>