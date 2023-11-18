<div class="page-form">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="<?= Yii::$app->request->get('section', 'general') == 'general' || Yii::$app->request->get('section', '') == '' ? 'active' : ''; ?>"><a data-toggle="tab" href="#tab_1">General</a></li>
            <?php if (!$model->isNewRecord) { ?>
                <li class="<?= Yii::$app->request->get('section') == 'attachment' ? 'active' : ''; ?>"><a data-toggle="tab" href="#tab_2">Attachments</a></li>                
            <?php } ?>
        </ul>
        <div class="tab-content">
            <div id="tab_1" class="tab-pane <?= Yii::$app->request->get('section', 'general') == 'general' || Yii::$app->request->get('section', '') == '' ? 'active' : ''; ?>">
                <?= $this->render('_form_general', ['model' => $model]) ?>
            </div><!-- /.tab-pane -->
            <?php if (!$model->isNewRecord) { ?>
                <div id="tab_2" class="tab-pane <?= Yii::$app->request->get('section') == 'attachment' ? 'active' : ''; ?>">
                    <?= $this->render('_form_attachment', ['pageModel' => $model]) ?>
                </div><!-- /.tab-pane -->
            <?php } ?>
        </div><!-- /.tab-content -->
    </div>

   

</div>
