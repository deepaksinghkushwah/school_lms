<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\Page;
use app\models\PageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Page();

        if ($model->load(Yii::$app->request->post())) {
            $alias = $model->alias != '' ? str_replace(" ", "-", strtolower($model->alias)) : str_replace(" ", "-", strtolower($model->title));
            $model->alias = $alias;
            $model->add_date = time();
            if ($model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $alias = $model->alias != '' ? str_replace(" ", "-", strtolower($model->alias)) : str_replace(" ", "-", strtolower($model->title));
            $model->alias = $alias;
            $model->modify_date = time();
            if ($model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionComment() {
        $searchModel = new \app\models\CommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('comments', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
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
            $name = md5(uniqid()) . "." . array_pop($ext);
            $target = Yii::$app->params['attachmentPathOs'] . $name;
            if (move_uploaded_file($images['tmp_name'][$i], $target)) {
                $success = true;
                $paths[] = $name;
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
            foreach($paths as $name){
                $img = new \app\models\PageAttachment();
                $img->page_id = Yii::$app->request->post('page_id');
                $img->filename = $name;
                $img->save();
                $output[] = $name.' Saved!';
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
    
    public function actionDeleteAttachment(){
        $id = Yii::$app->request->post('id');
        $model = \app\models\PageAttachment::findOne(['id' => $id]);
        @unlink(Yii::$app->params['attachmentPathOs'].$model->filename);
        \app\models\PageAttachment::deleteAll("id='$id'");
        return json_encode(['msg' => 'Selected attachment removed', 'status' => 1]);
    }

}
