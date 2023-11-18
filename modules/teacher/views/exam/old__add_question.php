<?php
if (!$model->isNewRecord) {
    $allQuestions = app\models\LmsQuestionBank::findAll(['class_id' => $model->class_id, 'subject_id' => $model->subject_id]);
    if ($allQuestions) {
        ?>
        <h3>Questions [Total Marks: <span id="totalMark"></span>]
            <span class="pull-right"><button type="button" id="addQuestionToExam" class="btn btn-primary btn-xs">Add Selected To This Exam</button></span>
        </h3>

        <div style="overflow: auto; max-height: 300px;">
            <table id="questionTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th>Question</th>
                        <th>Score Point</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($allQuestions as $row) {
                        ?>
                        <tr>
                            <td><input class="questionCheckbox" type="checkbox" value="<?= $row->id ?>"/></td>
                            <td><?= Yii::$app->formatter->asText($row->question_text); ?></td>
                            <td><input type="number" step="any" min="0" name="score_point" class="form-control" value="<?= $row->score_point ?>"/></td>
                        </tr>

                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
   