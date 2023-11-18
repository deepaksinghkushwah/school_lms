<?php
/* @var $this yii\web\View */
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/backend/form_attachment.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);

use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use kartik\file\FileInput;
// or 'use kartikile\FileInput' if you have only installed yii2-widget-fileinput in isolation
use yii\helpers\Url;

echo \yii\helpers\Html::hiddenInput('attachmentHref', Url::to(['/teacher/content/update', 'id' => $model->id, 'section' => 'attachment'], true), ['id' => 'attachmentHref']);
echo \yii\helpers\Html::beginForm('', 'post', ['enctype' => 'multipart/form-data']);

echo FileInput::widget([
    'name' => 'attachments[]',
    'id' => 'attachments',
    'options' => [
        'multiple' => true
    ],
    'pluginOptions' => [
        'uploadUrl' => Url::to(['/teacher/content/file-upload']),
        'uploadExtraData' => [
            'content_id' => $model->id,
        ],
        'allowedFileExtensions' => ['jpg', 'gif', 'png', 'pdf', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'],
        'initialPreviewAsData' => true,
        'overwriteInitial' => true,
        'maxFileSize' => 2800
    ]
]);


echo \yii\helpers\Html::endForm();


$amodel = \app\models\LmsContentAttachment::find()->where("content_id=" . $model->id)->all();
if ($amodel) {
    ?>
    <h3><b>Attachments</b></h3>
    <table class="table table-bordered">
        <?php
        foreach ($amodel as $row) {
            ?>
            <tr id="row_<?= $row->id; ?>">
                <td><?= $row->filename; ?></td>
                <td>
                    <a href="<?= Url::to(['/site/download-content-file','id' => $row->id],true)?>"  class="btn btn-primary">Download</a> 
                    <a href="javascript:void(0);" data-row-id="<?= $row->id; ?>" class="btn btn-danger btn-remove">Delete</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
}

