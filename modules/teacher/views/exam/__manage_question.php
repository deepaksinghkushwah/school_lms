<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LmsExamQuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerAssetBundle(app\assets\FrameAsset::class);
$this->title = 'Questions in Exam: ' . $searchModel->exam->title;
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/frontend/exam/manage_question.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
echo Html::hiddenInput("updateQuestionScoreUrl", \yii\helpers\Url::to(['/exam/update-exam-question-score'],true), ['id' => 'updateQuestionScoreUrl']);
echo Html::hiddenInput("deleteQuestionUrl", \yii\helpers\Url::to(['/exam/delete-exam-question'],true), ['id' => 'deleteQuestionUrl']);
?>
<div class="lms-exam-index">

    <h1><?= Html::encode($this->title) ?></h1>    <hr>
    <h3><span class="label label-primary">Total Points: <?= Yii::$app->db->createCommand("SELECT SUM(score_point) as total FROM lms_exam_question WHERE exam_id = :examID", [':examID' => $searchModel->exam_id])->queryScalar(); ?></span></h3>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'question_id' => [
                'label' => 'Question',
                'value' => function($model) {
                    return strip_tags($model->question->question_text);
                },
                'attribute' => 'question_id'
            ],
            [
                'label' => 'Sort Order',
                'attribute' => 'sort_order',
                'value' => function($model) {
                    return "<input type='number' data-id='".$model->id."' step='1' min='0' class='sortOrder form-control' value='" . $model->sort_order . "'>";
                },
                'headerOptions' => ['width' => '10%'],
                'format' => 'raw'
            ],
            'score_point' => [
                'label' => 'Score Point',
                'value' => function($model) {
                    return "<input type='number' data-id='".$model->id."' step='any' min='0' class='scorePoint form-control' value='" . $model->score_point . "'>";
                },
                'headerOptions' => ['width' => '10%'],
                'format' => 'raw'
            ],
//            'created_at' => [
//                'attribute' => 'created_at',
//                'label' => 'Add Date',
//                'value' => function($model) {
//                    return date(Yii::$app->params['dateFormat'], strtotime($model->created_at));
//                },
//                'format' => 'html',
//                'headerOptions' => ['width' => '20%'],
//                'filter' => \yii\jui\DatePicker::widget(['language' => 'en', 'dateFormat' => 'yyyy-MM-dd', 'name' => 'LmsQuestionBankSearch[created_at]', 'value' => (isset($_REQUEST['LmsQuestionBankSearch']['created_at'])) ? $_REQUEST['LmsQuestionBankSearch']['created_at'] : '']),
//            ],
//            'score_point' => [
//                'label' => 'Score Point',
//                'value' => function($model) {
//                    return "<input type='number' step='any' min='0' class='scorePoint form-control' value='" . $model->score_point . "'>";
//                },
//                'format' => 'raw'
//            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '10%'],
                'template' => "{deleteQuestion}",//{saveQuestionScore} 
                'buttons' => [
                    'deleteQuestion' => function($url, $model, $key) {
                        return "<a class='deleteQuestion' data-id='" . $model->id . "' title='Delete question from current exam' href='javascript:void(0)'><i class='fa fa-trash'></i></a>";
                    },
                    'saveQuestionScore' => function($url, $model, $key) {
                        return "<a class='saveScorePoint' data-id='" . $model->id . "' title='Save score point' href='javascript:void(0)'><i class='fa fa-save'></i></a>";
                    }
                ]
            ],
        ],
    ]);
    ?>


</div>
