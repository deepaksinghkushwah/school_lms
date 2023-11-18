<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LmsExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $examModel app\models\LmsExam */
$this->registerAssetBundle(app\assets\FrameAsset::class);
$this->title = 'Add Question To ' . $examModel->title;
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/frontend/exam/add_question.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
echo Html::hiddenInput("examId", $examModel->id, ['id' => 'examId']);
?>
<div class="lms-exam-index">

    <h1><?= Html::encode($this->title) ?></h1><hr>
    <p class="help-block"><b>Note:</b> Text in red is already added questions to exam</p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            $exists = app\models\LmsExamQuestion::findOne(['exam_id' => Yii::$app->request->get('exam_id'), 'question_id' => $model->id]);
            if ($exists) {
                return ['class' => 'addedInQuestion','title' => 'Already added to current exam'];
            } else {
                return [];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'question_text',
            'created_at' => [
                'attribute' => 'created_at',
                'label' => 'Add Date',
                'value' => function($model) {
                    return date(Yii::$app->params['dateFormat'], strtotime($model->created_at));
                },
                'format' => 'html',
                'headerOptions' => ['width' => '20%'],
                'filter' => \yii\jui\DatePicker::widget(['language' => 'en', 'dateFormat' => 'yyyy-MM-dd', 'name' => 'LmsQuestionBankSearch[created_at]', 'value' => (isset($_REQUEST['LmsQuestionBankSearch']['created_at'])) ? $_REQUEST['LmsQuestionBankSearch']['created_at'] : '','options' => ['class' => 'form-control'],]),
            ],
            'score_point' => [
                'label' => 'Score Point',
                'value' => function($model) {
                    return "<input type='number' step='any' min='0' class='scorePoint form-control' value='" . $model->score_point . "'>";
                },
                'format' => 'raw'
            ],
            
            [
                'class' => 'yii\grid\ActionColumn', 'template' => "{addQuestion}",
                'buttons' => [
                    'addQuestion' => function($url, $model, $key) {
                        $exists = app\models\LmsExamQuestion::findOne(['exam_id' => Yii::$app->request->get('exam_id'), 'question_id' => $model->id]);
                        if(!$exists){
                            return Html::a("<i class='fa fa-plus'></i>", 'javascript:void(0)', ['class' => 'btnAddQuestionToExam', 'title' => 'Add This', 'data-qid' => $model->id]);
                        }
                    },
                ]
            ],
        ],
    ]);
    ?>


</div>
