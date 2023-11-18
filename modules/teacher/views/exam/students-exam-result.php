<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LmsExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerAssetBundle(app\assets\FrameAsset::class);
$this->title = 'Results For: ' . \app\models\LmsExam::findOne($examId)->title;
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/select2/js/select2.full.min.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(yii\helpers\BaseUrl::base() . '/js/select2/css/select2.min.css');
$this->registerCss(".select2-container .select2-selection--single{height: 33px;}");
$this->registerJs("$('.select2').select2()");
//echo Html::hiddenInput("examId", $examModel->id, ['id' => 'examId']);
?>
<div class="lms-exam-index">

    <h1><?= Html::encode($this->title) ?></h1> <hr>   
    <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['/exam/students-exam-result', 'exam_id' => $examId], true) ?>">Reset</a>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Student',
                'value' => function($model) {
                    return $model->student->profile->fullname;
                },
                'headerOptions' => ['width' => '30%'],
                'filter' => Html::dropDownList('LmsStudentResultMainSearch[student_id]', (isset($_REQUEST['LmsStudentResultMainSearch']['student_id']) ? $_REQUEST['LmsStudentResultMainSearch']['student_id'] : ''), $examStudents, ['prompt' => 'Select ANY', 'class' => 'select2 form-control', 'style' => 'width: 100%']),
            ],
            'created_at' => [
                'attribute' => 'created_at',
                'label' => 'Attempted At',
                'value' => function($model) {
                    return date(Yii::$app->params['dateFormat'], strtotime($model->created_at));
                },
                'format' => 'html',
                'headerOptions' => ['width' => '20%'],
                'filter' => \yii\jui\DatePicker::widget(['language' => 'en', 'dateFormat' => 'yyyy-MM-dd', 'name' => 'LmsStudentResultMainSearch[created_at]', 'value' => (isset($_REQUEST['LmsStudentResultMainSearch']['created_at'])) ? $_REQUEST['LmsStudentResultMainSearch']['created_at'] : '','options' => ['class' => 'form-control'],]),
            ],
            'score' => [
                'label' => 'Score Point',
                'value' => function($model) {
                    return number_format($model->score, 2) . ' / ' . number_format($model->exam_total_score,2);
                },
                'headerOptions' => ['width' => '10%'],
            ],
        ],
    ]);
    ?>


</div>
