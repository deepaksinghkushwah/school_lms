<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LmsQuestionAnswerOptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Answer options for question id: '.$qid;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lms-question-answer-option-index">

    <h1><?= Html::encode($this->title) ?></h1><hr>

    <p>
        <?= Html::a('Create Answer Option', ['create','qid' => $qid], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],            
            'answer_text:ntext',
            'is_correct_answer' => [
                'label' => 'Is this correct?',
                'value' => function($model){
                    return $model->is_correct_answer == 1 ? 'Yes' : 'No';
                }
            ],
            ['class' => 'yii\grid\ActionColumn','template' => "{update} {delete}"],
        ],
    ]); ?>


</div>
