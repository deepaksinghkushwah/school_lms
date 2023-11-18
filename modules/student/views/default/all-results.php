<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\LmsStudentResultSearch */
$this->title = Yii::$app->request->get('exam_id') ? "Exam results" : 'All Exams Result';

use yii\grid\GridView;
?>
<h1><?= $this->title ?></h1><hr>
<a class="btn btn-primary" href="<?= yii\helpers\Url::to(['/student/default/exams'], true); ?>">Back to exams</a><br><br>
<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'exam_id',
            'label' => 'Exam Name',
            'value' => function($model) {
                return $model->exam->title;
            },
            'filter' => yii\helpers\Html::dropDownList("LmsStudentResultSearch[exam_id]", (isset($_REQUEST['LmsStudentResultSearch']) ? $_REQUEST['LmsStudentResultSearch'] : ''), \yii\helpers\ArrayHelper::map(Yii::$app->db->createCommand("SELECT id,title FROM lms_exam WHERE id IN (SELECT exam_id FROM `lms_student_result` WHERE student_id = '" . Yii::$app->user->id . "' GROUP BY exam_id)")->queryAll(), 'id', 'title'), ['prompt' => 'Select Any', 'class' => 'form-control']),
            'contentOptions' => ["width" => "40%"],
        ],
        [
            'label' => 'Exam Total',
            'value' => function($model) {
                return $model->exam->getScore($model->exam_id);
            },
            'contentOptions' => ["width" => "10%"],
        ],
        [
            'label' => 'Your Score',
            'value' => function($model) {
                return $model->getTotal($model->attempt_id);
            },
            'contentOptions' => ["width" => "10%"],
        ],
        'created_at' => [
            //'attribute' => 'created_at',
            'label' => 'Attempt Date',
            'value' => function($model) {
                return date(Yii::$app->params['dateFormat'] . ' H:i', strtotime($model->created_at));
            },
            'format' => 'html',
            'contentOptions' => ['width' => '25%'],
            'filter' => \yii\jui\DatePicker::widget(['language' => 'en', 'dateFormat' => 'yyyy-MM-dd', 'name' => 'LmsStudentResultSearch[created_at]', 'value' => (isset($_REQUEST['LmsStudentResultSearch']['created_at'])) ? $_REQUEST['LmsStudentResultSearch']['created_at'] : '', 'options' => ['class' => 'form-control']]),
        ],
        [
            'label' => 'Detail Result',
            'value' => function($model) {
                return "<a title='View exam result' href='" . yii\helpers\Url::to(['/student/default/show-result', 'exam_id' => $model->exam_id, 'attempt_id' => $model->attempt_id], true) . "'><i class='glyphicon glyphicon-education'></i></a>";
            },
            'format' => 'html',
            'contentOptions' => ["width" => "15%"],
        ],
        [
            'label' => 'Certificate',
            'value' => function($model) {
                return yii\helpers\Html::a("<i class='glyphicon glyphicon-download'></i>", yii\helpers\Url::to(['/student/default/generate-cert', 'id' => $model->attempt_id], true), ['title' => 'Download Certificate']);
            },
            'format' => 'html',
        ],
    ],
]);
