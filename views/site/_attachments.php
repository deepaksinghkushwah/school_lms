<?php
$amodel = \app\models\PageAttachment::find()->where("page_id=" . $pageModel->id)->all();
if ($amodel) {
    ?>

    <h3><b>Attachments</b></h3>
    <div class="row">
        <?php
        $c = 0;
        foreach ($amodel as $row) {
            $ext = substr($row->filename, strrpos($row->filename, '.') + 1);
            switch ($ext) {
                case 'pdf':
                case 'txt':
                    $type = "text";
                    break;
                case 'jpg':
                case 'jpeg':
                case 'gif':
                case 'png':
                    $type = "image";
                    break;
                default:
                    $type="text";
            }
            ?>
            <div class="col-lg-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php
                        if ($type == 'image') {
                            echo \yii\helpers\Html::img(yii\helpers\Url::to([Yii::$app->params['attachmentPathWeb'] . $row->filename], true), ['class' => 'img-responsive img-thumbnail']) . "<Br/>";
                        } else {
                            echo \yii\helpers\Html::img(yii\helpers\Url::to(['/images/contentfile.png'], true), ['class' => 'img-responsive img-thumbnail']) . "<Br/>";
                        }
                        ?>
                    </div>
                    <div class="panel-footer">
                        <?php echo \yii\helpers\Html::a('Download '.strtoupper($ext), yii\helpers\Url::to(['/site/download-file', 'id' => $row->id], true), ['class' => 'btn btn-xs btn-warning']); ?>
                        
                    </div>
                </div>


                
            </div>
            <?php
            $c++;
            if ($c % 6 == 0) {
                echo "</div><div class='row'>";
            }
        }
        ?>
    </div>
    <hr/>
    <?php
}