<?php

namespace app\modules\backend\controllers;

use Yii;
use app\models\Theme;
use app\models\ThemeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ThemeController implements the CRUD actions for Theme model.
 */
class ThemeController extends Controller {

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
     * Lists all Theme models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ThemeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Theme model.
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
     * Creates a new Theme model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Theme();

        if ($model->load(Yii::$app->request->post())) {
            $model->filename = \yii\web\UploadedFile::getInstance($model, 'filename');
            if ($model->filename) {
                $name = uniqid() . '.' . $model->filename->extension;                
                $model->filename->saveAs(Yii::$app->params['themePathOs'] . $name);
                $model->filename = $name;
            }
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Theme uploaded.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Theme model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->filename = \yii\web\UploadedFile::getInstance($model, 'filename');
            if ($model->filename) {              
                //@unlink(Yii::$app->basePath . '/web/filenames/profile/'.Userprofile::find()->where("user_id='".Yii::$app->user->id."'")->one()->filename);
                $name = uniqid() . '.' . $model->filename->extension;;
                $model->filename->saveAs(Yii::$app->params['themePathOs'] . $name);
                $model->filename = $name;                
            } else {
                $model->filename = Theme::find()->where("id='".$model->id."'")->one()->filename;
            }
            
            if($model->save()){
                Yii::$app->getSession()->setFlash('success' , 'Theme updated');
                return $this->redirect(['index']);
            } 
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Theme model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        @unlink(Yii::$app->params['themePathOs'] . $model->filename);
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Theme model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Theme the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Theme::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionMakeDefault($id){
        $model = $this->findModel($id);
        $model->default = 1;
        $model->save();
        return $this->redirect(['index']);
    }

}
