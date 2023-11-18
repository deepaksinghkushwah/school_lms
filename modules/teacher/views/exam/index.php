<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LmsExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Exams';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/fancybox/jquery.fancybox.min.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(yii\helpers\Url::to(['/js/fancybox/jquery.fancybox.css'], true));

$js = "$('.btnExamQuestion').fancybox({
    iframe : {
        css : {
            width : '80%',
            height: '600px',
        }
    },
    afterClose: function () { 
        window.location.reload();
    }
});;";
$this->registerJs($js);
$postedModel = Yii::$app->request->get("LmsExamSearch");
$postedSubjectID = isset($postedModel['subject_id']) ? $postedModel['subject_id'] : 0;
$postedClassID = isset($postedModel['class_id']) ? $postedModel['class_id'] : 0;

$classSubjects = app\models\LmsMasterClass::getClassSubjects((int)$postedClassID);
?>
<div class="lms-exam-index">

    <h1><?= Html::encode($this->title) ?></h1><hr>

    <p>
        <?= Html::a('Create Exam', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Reset Search', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'class_id' => [
                'label' => 'Class',
                'value' => function($model) {
                    return $model->class->title;
                },
                'filter' => Html::dropDownList('LmsExamSearch[class_id]',$postedClassID, yii\helpers\ArrayHelper::map(app\models\LmsMasterClass::find()->all(), 'id', 'title'), ['prompt' => 'Select ANY', 'class' => 'form-control']),
                'headerOptions' => ['width' => '15%'],
            ],
            'subject_id' => [
                'label' => 'Subject',
                'value' => function($model) {
                    return $model->subject->title;
                },
                'filter' => Html::dropDownList('LmsExamSearch[subject_id]', $postedSubjectID, yii\helpers\ArrayHelper::map($classSubjects, 'id', 'title'), ['prompt' => 'Select ANY', 'class' => 'form-control']),
                'headerOptions' => ['width' => '15%'],
            ],
            [
                'label' => 'Total Marks',
                'value' => function($model) {
                    $total = Yii::$app->db->createCommand("SELECT sum(score_point) as total FROM lms_exam_question WHERE exam_id = :id", [':id' => $model->id])->queryScalar();
                    return $total;
                }
            ],
            /* 'created_at' => [
              'attribute' => 'created_at',
              'label' => 'Add Date',
              'value' => function($model) {
              return date(Yii::$app->params['dateFormat'], strtotime($model->created_at));
              },
              'format' => 'html',
              'headerOptions' => ['width' => '20%'],
              'filter' => \yii\jui\DatePicker::widget(['language' => 'en', 'dateFormat' => 'yyyy-MM-dd', 'name' => 'LmsExamSearch[created_at]', 'value' => (isset($_REQUEST['LmsExamSearch']['created_at'])) ? $_REQUEST['LmsExamSearch']['created_at'] : '']),
              ], */
            //'created_by',
            //'updated_at',
            //'updated_by',
            'status' => [
                'label' => 'Status',
                'value' => function($model) {
                    return $model->status == 1 ? 'Active' : 'Inactive';
                },
                'attribute' => 'status',
                'format' => 'html',
                'filter' => Html::dropDownList('LmsExamSearch[status]', (isset($_REQUEST['LmsExamSearch']['status']) ? $_REQUEST['LmsExamSearch']['status'] : ''), ['1' => 'Active', '0' => 'Inactive'], ['prompt' => 'Select ANY', 'class' => 'form-control']),
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => "{update} {delete} {addQuestion} {manageQuestion} {studentResult}",
                'headerOptions' => ['width' => '120px'],
                'buttons' => [
                    'addQuestion' => function($url, $model, $key) {
                        return Html::a("<i class='glyphicon glyphicon-plus'></i>", yii\helpers\Url::to(['/teacher/exam/add-question', 'exam_id' => $model->id], true), ['data-fancybox' => '', 'data-type' => 'iframe', 'class' => 'btnExamQuestion', 'title' => 'Add Questions to Exam']);
                    },
                    'manageQuestion' => function($url, $model, $key) {
                        return Html::a("<i class='glyphicon glyphicon-cog'></i>", yii\helpers\Url::to(['/teacher/exam/manage-question', 'exam_id' => $model->id], true), ['data-fancybox' => '', 'data-type' => 'iframe', 'class' => 'btnExamQuestion', 'title' => 'Manage Exam Questions']);
                    },
                    'studentResult' => function($url, $model, $key) {
                        return Html::a("<i class='glyphicon glyphicon-user'></i>", yii\helpers\Url::to(['/teacher/exam/students-exam-result', 'exam_id' => $model->id], true), ['data-fancybox' => '', 'data-type' => 'iframe', 'class' => 'btnExamQuestion', 'title' => 'View student results']);
                    },
                ]
            ],
        ],
    ]);
    ?>


</div>
