<?php
/* @var $this yii\web\View */
/* @var $model app\models\LmsVideoComment */
/* @var $videoID int */

$rows = \app\models\LmsVideoComment::find()->where(['parent_id' => 0, 'video_id' => $videoID])->orderBy(['id' => SORT_DESC])->all();
if ($rows) {

    echo "<h1>Previous Questions</h1>";
    ?>
    <table class="table table-striped">
        <?php
        foreach ($rows as $row) {
            ?>
            <tr id="q<?=$row->id?>"><td>
                    <p>
                        <strong>Question: </strong><i><?= $row->content; ?></i>
                        <div>
                            By <?= \app\models\Userprofile::findOne(['user_id' => $row->created_by])->fullname ?>
                            at <?=date('l d M Y', strtotime($row->created_at))?>
                        </div>
                    </p>
                    <?php
                    $subrows = \app\models\LmsVideoComment::find()->where(['parent_id' => $row->id])->orderBy(['id' => SORT_DESC])->all();
                    if ($subrows) {
                        ?>
                        <table class="table table-striped">
                            <tr>
                                <th colspan="3"><strong>Replies</strong></th>
                            </tr>
                            <?php
                            foreach ($subrows as $srow) {
                                ?>
                            
                                <tr>
                                    <td width="20%"><?= date("l d M Y", strtotime($srow->created_at)) ?></td>
                                    <td width="15%"><?= \app\models\Userprofile::findOne(['user_id' => $srow->created_by])->fullname ?></td>
                                    <td width="65%"><?= $srow->content; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <?php
                    }
                    ?>
                    <?= $this->render('video-comment-form', ['videoID' => $videoID, 'parentID' => $row->id, 'textAreaLabel' => 'Reply']); ?>

                </td>
            </tr>
            <tr style="height: 50px;">
                <td>&nbsp;</td>
            </tr>
            
            <?php
        }
        ?>
    </table>
    <?php
}
?>


