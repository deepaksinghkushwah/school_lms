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

$js = "$('.btnViewResult').fancybox({
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
        <?= Html::a('Reset Search', ['exams'], ['class' => 'btn btn-primary']) ?>
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
                'filter' => Html::dropDownList('LmsExamSearch[class_id]', $postedClassID, yii\helpers\ArrayHelper::map(\app\modules\student\components\StudentHelper::getStudentCourses(Yii::$app->user->id), 'id', 'title'), ['prompt' => 'Select ANY', 'class' => 'form-control']),
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
            ['class' => 'yii\grid\ActionColumn', 'template' => "{takeExam} {viewResult}", 'headerOptions' => ['width' => '100px'],
                'buttons' => [
                    'takeExam' => function($url, $model, $key) {
                        return Html::a("<i class='glyphicon glyphicon-briefcase'></i>", yii\helpers\Url::to(['/student/default/take-exam', 'exam_id' => $model->id], true), ['title' => 'Take Exam']);
                    },
                    'viewResult' => function($url, $model, $key) {
                        return Html::a("<i class='glyphicon glyphicon-list'></i>", yii\helpers\Url::to(['/student/default/all-results', 'exam_id' => $model->id], true), ['title' => 'View Result']);
                    },
                    
                ]
            ],
        ],
    ]);
    ?>


</div>
