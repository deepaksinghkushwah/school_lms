<?php
/* @var $this yii\web\View */
/* @var $classModel app\models\LmsMasterClass */
$this->title = "Video Content";

use yii\grid\GridView;
$postedModel = Yii::$app->request->get("LmsVideoSearch");
$postedSubjectID = isset($postedModel['subject_id']) ? $postedModel['subject_id'] : 0;
$postedClassID = isset($postedModel['class_id']) ? $postedModel['class_id'] : 0;

$classSubjects = app\models\LmsMasterClass::getClassSubjects((int)$postedClassID);

?>
<h1><?=$this->title?></h1><hr>
<?php

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'title' => [
            'label' => 'Title',
            'value' => function($model) {
                return \yii\helpers\Html::a($model->title, yii\helpers\Url::to(['/student/default/video-view', 'id' => $model->id], true),['title' => 'View: '.$model->title]);
            },
            'format' => 'html',
            'attribute' => 'title',
            'headerOptions' => ['width' => '30%'],
        ],
        'class_id' => [
            'attribute' => 'class_id',
            'label' => 'Class',
            'value' => function($model) {
                return $model->class->title;
            },
            'filter' => \yii\helpers\Html::dropDownList("LmsVideoSearch[class_id]",$postedClassID, \yii\helpers\ArrayHelper::map(app\modules\student\components\StudentHelper ::getStudentCourses(Yii::$app->user->id), 'id', 'title'), ['prompt' => 'Select Any', 'class' => 'form-control']),
            'headerOptions' => ['width' => '20%'],
        ],
        'subject_id' => [
            'attribute' => 'subject_id',
            'label' => 'Subject',
            'value' => function($model) {
                return $model->subject->title;
            },
            'filter' => \yii\helpers\Html::dropDownList("LmsVideoSearch[subject_id]", $postedSubjectID, \yii\helpers\ArrayHelper::map($classSubjects, 'id', 'title'), ['prompt' => 'Select Any', 'class' => 'form-control']),
            'headerOptions' => ['width' => '20%'],
        ],
        'created_at' => [
            'attribute' => 'created_at',
            'label' => 'Add Date',
            'value' => function($model) {
                return date(Yii::$app->params['dateFormat'], strtotime($model->created_at));
            },
            'format' => 'html',
            'headerOptions' => ['width' => '20%'],
            'filter' => \yii\jui\DatePicker::widget(['language' => 'en', 'dateFormat' => 'yyyy-MM-dd', 'name' => 'LmsVideoSearch[created_at]', 'class' => 'form-control', 'value' => (isset($_REQUEST['LmsVideoSearch']['created_at'])) ? $_REQUEST['LmsVideoSearch']['created_at'] : '']),
        ],
        
    ],
]);
?>