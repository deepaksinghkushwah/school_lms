<?php

namespace app\modules\teacher\controllers;
use app\models\LmsContent;
use app\models\LmsContentSearch;
use Yii;
class ContentController extends \yii\web\Controller {

    /**
     * Lists all LmsContent models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new LmsContentSearch();
        $searchModel->created_by = Yii::$app->user->id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LmsContent model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LmsContent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new LmsContent();
        $model->created_by = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash("success", "Content created");
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing LmsContent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash("success", "Content updated");
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LmsContent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LmsContent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LmsContent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = LmsContent::findOne(['id' => $id, 'created_by' => Yii::$app->user->id])) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFileUpload() {
        if (empty($_FILES['attachments'])) {
            return json_encode(['error' => 'No files found for upload.']);
        }

        // get the files posted
        $images = $_FILES['attachments'];

        // a flag to see if everything is ok
        $success = null;

        // file paths to store
        $paths = [];

        // get file names
        $filenames = $images['name'];

        // loop and process files
        for ($i = 0; $i < count($filenames); $i++) {
            $ext = explode('.', basename($filenames[$i]));
            $name = md5(uniqid()) . "." . $ext[1];
            $target = Yii::$app->params['contentAttachmentPathOs'] . $name;
            if (move_uploaded_file($images['tmp_name'][$i], $target)) {
                $success = true;
                $paths[] = ['filename' => $name, 'type' => $ext[1], 'title' => $ext[0]];
            } else {
                $success = false;
                break;
            }
        }

        // check and process based on successful status 
        if ($success === true) {
            // call the function to save all data to database
            // code for the following function `save_data` is not 
            // mentioned in this example
            foreach ($paths as $name) {
                $img = new \app\models\LmsContentAttachment();
                $img->content_id = Yii::$app->request->post('content_id');
                $img->filename = $name['filename'];
                $img->file_type = $name['type'];
                $img->file_title = $name['title'];
                $img->save();
                $output[] = $name['title'] . ' Saved!';
            }
            // store a successful response (default at least an empty array). You
            // could return any additional response info you need to the plugin for
            // advanced implementations.
            // for example you can get the list of files uploaded this way
            // $output = ['uploaded' => $paths];
        } elseif ($success === false) {
            $output = ['error' => 'Error while uploading images. Contact the system administrator'];
            // delete any uploaded files
            foreach ($paths as $file) {
                unlink($file);
            }
        } else {
            $output = ['error' => 'No files were processed.'];
        }

        // return a json encoded response for plugin to process successfully
        return json_encode($output);
    }

    public function actionDeleteAttachment() {
        $id = Yii::$app->request->post('id');
        $model = \app\models\LmsContentAttachment::findOne(['id' => $id]);
        @unlink(Yii::$app->params['contentAttachmentPathOs'] . $model->filename);
        \app\models\LmsContentAttachment::deleteAll("id='$id'");
        return json_encode(['msg' => 'Selected attachment removed', 'status' => 1]);
    }

    public function actionToggleContentStatus($id) {
        $model = $this->findModel($id);
        $model->status = (int) !$model->status;
        $model->save();
        Yii::$app->session->setFlash("success", "Content status updated");
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function actionGetClassSubject(){
        $classID = Yii::$app->request->get('class_id',0);
        if($classID != 0){
            $subjects = \app\models\LmsMasterClass::getClassSubjects($classID);
        } else {
            $subjects = [];
        }
        return json_encode(['status' => 1, 'subjects' => $subjects]);
    }
    
}
