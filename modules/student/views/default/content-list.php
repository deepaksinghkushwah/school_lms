<?php
/* @var $this yii\web\View */
/* @var $classModel app\models\LmsMasterClass */
$this->title = "Content Listing For \"" . $classModel->title . "\"";
$teachers = \app\components\GeneralHelper::getUsersByRole("Teacher");
array_unshift($teachers, ['id' => '1', 'fullname' => 'Administrator']);
if (isset($_REQUEST['LmsContentSearch']['class_id'])) {
    $postedClassID = $_REQUEST['LmsContentSearch']['class_id'];
} elseif (isset($_REQUEST['class_id'])) {
    $postedClassID = $_REQUEST['class_id'];
} else {
    $postedClassID = "";
}

$classSubjects = app\models\LmsMasterClass::getClassSubjects($postedClassID);

use yii\grid\GridView;
?>
<h1><?= $this->title ?></h1><hr>
<a class="btn btn-primary" href="<?= yii\helpers\Url::to(['/student/default/index'], true); ?>">Back to class</a>&nbsp;<a class="btn btn-primary" href="<?= yii\helpers\Url::to(['/student/default/content-list', 'class_id' => $classModel->id], true); ?>">Reset Search</a><br><br><br><br>
<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
            [
            'attribute' => 'created_by',
            'label' => 'Author',
            'value' => function($model) {
                return ucwords(\app\models\Userprofile::findOne(['user_id' => $model->created_by])->fullname);
            },
            'filter' => \yii\helpers\Html::dropDownList('LmsContentSearch[created_by]', (isset($_REQUEST['LmsContentSearch']['created_by']) ? $_REQUEST['LmsContentSearch']['created_by'] : ''), \yii\helpers\ArrayHelper::map($teachers, 'id', 'fullname'), ['class' => 'form-control', 'prompt' => 'Select Any']),
            'headerOptions' => ['width' => '20%'],
        ],
        'title' => [
            'label' => 'Title',
            'value' => function($model) {
                return \yii\helpers\Html::a($model->title, yii\helpers\Url::to(['/student/default/content-detail', 'id' => $model->id], true));
            },
            'format' => 'html',
            'attribute' => 'title',
            'headerOptions' => ['width' => '20%'],
        ],
        'class_id' => [
            'attribute' => 'class_id',
            'label' => 'Class',
            'value' => function($model) {
                return $model->class->title;
            },
            'filter' => \yii\helpers\Html::dropDownList("LmsContentSearch[class_id]", $postedClassID, \yii\helpers\ArrayHelper::map(app\modules\student\components\StudentHelper ::getStudentCourses(Yii::$app->user->id), 'id', 'title'), ['class' => 'form-control']),
            'headerOptions' => ['width' => '20%'],
        ],
        'subject_id' => [
            'attribute' => 'subject_id',
            'label' => 'Subject',
            'value' => function($model) {
                return $model->subject->title;
            },
            'filter' => \yii\helpers\Html::dropDownList("LmsContentSearch[subject_id]", (isset($_REQUEST['LmsContentSearch']['subject_id']) ? $_REQUEST['LmsContentSearch']['subject_id'] : ''), \yii\helpers\ArrayHelper::map($classSubjects, 'id', 'title'), ['prompt' => 'Select Any', 'class' => 'form-control']),
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
            'filter' => yii\helpers\Html::textInput("LmsContentSearch[created_at]", ((isset($_REQUEST['LmsContentSearch']['created_at'])) ? $_REQUEST['LmsContentSearch']['created_at'] : ''), ['class' => 'form-control datepicker', 'id' => 'created_at'])
        ]
    ],
]);
$js = "$('#created_at').datepicker({dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true,maxDate: '+0D'})";
$this->registerJs($js);
/*
 * \yii\jui\DatePicker::widget([
                'language' => 'en', 
                'dateFormat' => 'yyyy-MM-dd', 
                'name' => 'LmsContentSearch[created_at]', 
                'value' => (isset($_REQUEST['LmsContentSearch']['created_at'])) ? $_REQUEST['LmsContentSearch']['created_at'] : '',
                
                ]),'options' => [
                      'class' => 'form-control',
                ]
 */