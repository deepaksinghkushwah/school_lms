<?php
if ($pageModel->allow_comment == 1 && isset(Yii::$app->user->id)) {
    ?>
    <h4>Add Comments</h4>
    <div class="row">
        <div class="col-md-12">
            <div class=" panel panel-default">
                <div class="panel-body">
                    <?php
                    
                    $form = \yii\bootstrap\ActiveForm::begin(['id' => 'comment-form']);
                    $form->errorSummary($newCommentModel);
                    echo $form->field($newCommentModel, 'subject')->textInput();
                    echo $form->field($newCommentModel, 'comment')->textArea();
                    echo yii\helpers\Html::submitButton("Add Comment", ['class' => 'btn btn-primary']);
                    \yii\bootstrap\ActiveForm::end();
                    
                    ?>
                </div>
            </div>
        </div>        
    </div>
    <p></p>
    <?php
}


$comments = app\models\Comment::find()->where(['page_id' => $pageModel->id, 'status' => 1])->orderBy(['id' => SORT_DESC])->all();
if ($comments) {
    foreach ($comments as $row) {
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">                        
                        
                            <b><?=$row->user->profile->fullname;?></b>, <?=date(Yii::$app->params['dateFormat'],strtotime($row->created_at));?>
                        
                    </div>
                    <div class="panel-body">
                        <b><?= $row->subject; ?></b><br>
                            <?= $row->comment; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
