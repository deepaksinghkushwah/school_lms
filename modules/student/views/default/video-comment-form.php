<?php
/* @var $this yii\web\View */
/* @var $model app\models\LmsVideocomment */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

//$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/ckeditor/ckeditor.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);

$model = new \app\models\LmsVideoComment();
$model->video_id = $videoID;
$model->parent_id = $parentID;
?>


<?php $form = ActiveForm::begin(['action' => Url::to(['/student/default/video-comment-create'], true)]); ?>
<?= $form->field($model, 'video_id')->hiddenInput()->label(false); ?>
<?= $form->field($model, 'parent_id')->hiddenInput()->label(false); ?>
<?= $form->field($model, 'content')->textarea(['rows' => 1, 'class' => 'form-control'])->label($textAreaLabel) ?>
<div class="form-group">
    <?= Html::submitButton($parentID == 0 ? 'Post Question' : 'Add Reply', ['class' => 'btn btn-primary']) ?>        
</div>

<?php ActiveForm::end(); ?>



