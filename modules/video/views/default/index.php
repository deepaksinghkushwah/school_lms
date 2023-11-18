<?php
/* @var $this yii\web\View */
/* @var $classModel app\models\LmsMasterClass */
$this->title = "Video Content";
$postedModel = Yii::$app->request->get("LmsVideoSearch");
$postedSubjectID = isset($postedModel['subject_id']) ? $postedModel['subject_id'] : 0;
$postedClassID = isset($postedModel['class_id']) ? $postedModel['class_id'] : 0;

$classSubjects = app\models\LmsMasterClass::getClassSubjects((int)$postedClassID);

use yii\grid\GridView;
?>
<div class="video-default-index">

    <h1>Video Lectures</h1>
    <p><a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['/video/default/create'], true) ?>">Create Video Lecture</a></p>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title' => [
                'label' => 'Title',
                'value' => function($model) {
                    return \yii\helpers\Html::a($model->title, yii\helpers\Url::to(['/video/default/update', 'id' => $model->id], true));
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
                'filter' => \yii\helpers\Html::dropDownList("LmsVideoSearch[class_id]", (isset($_REQUEST['LmsVideoSearch']['class_id']) ? $_REQUEST['LmsVideoSearch']['class_id'] : ''), \yii\helpers\ArrayHelper::map(app\models\LmsMasterClass::find()->orderBy(['id' => SORT_ASC])->all(), 'id', 'title'), ['prompt' => 'Select Any', 'class' => 'form-control']),
                'headerOptions' => ['width' => '20%'],
            ],
            'subject_id' => [
                'attribute' => 'subject_id',
                'label' => 'Subject',
                'value' => function($model) {
                    return $model->subject->title;
                },
                'filter' => \yii\helpers\Html::dropDownList("LmsVideoSearch[subject_id]", (isset($_REQUEST['LmsVideoSearch']['subject_id']) ? $_REQUEST['LmsVideoSearch']['subject_id'] : ''), \yii\helpers\ArrayHelper::map($classSubjects, 'id', 'title'), ['prompt' => 'Select Any', 'class' => 'form-control']),
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
                       ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}','headerOptions' => ['width' => '10%'],]
        ],
    ]);
    ?>
</div>