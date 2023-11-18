<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\Media;
use app\models\MediaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MediaController implements the CRUD actions for Media model.
 */
class MediaController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Media models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MediaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Media model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Media();

        if ($model->load(Yii::$app->request->post())) {
            $model->file_name = \yii\web\UploadedFile::getInstance($model, 'file_name');
            if ($model->file_name) {
                $name = uniqid() . '.' . $model->file_name->extension;
                $model->file_type = $model->file_name->extension;
                $model->file_name->saveAs(Yii::$app->params['mediaPathOs'] . $name);
                $model->file_name = $name;
            }
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Media created.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Media model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Media model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        unlink(Yii::$app->params['mediaPathOs'] . $model->file_name);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Media model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Media the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Media::findOne(['id' => $id, 'created_by' => Yii::$app->user->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionBulkUpload() {

        return $this->render('bulk-upload');
    }

    public function actionBulkUploadProcess() {

        $path = Yii::$app->params['mediaPathOs'];
        @mkdir($path, 0777, true);
        $valid = ['jpg', 'jpeg', 'png', 'gif'];
        if (isset($_FILES['file'])) {
            $ext = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], '.') + 1);
            if (in_array($ext, $valid)) {
                $basename = substr($_FILES['file']['name'], 0, strrpos($_FILES['file']['name'], '.') - 1);
                $filename = uniqid() . $basename . '.' . $ext;
                if (move_uploaded_file($_FILES['file']['tmp_name'], $path . '/' . $filename)) {

                    $model = new \app\models\Media();
                    $model->file_title = $basename;
                    $model->file_name = $filename;
                    $model->file_type = $ext;
                    $model->save();
                }
            } else {
                header("HTTP/1.0 400 Bad Request");
                echo 'Invalid filetype ' . $ext;
                exit;
            }
        }
    }

}
