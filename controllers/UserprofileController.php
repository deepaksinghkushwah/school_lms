<?php

namespace app\controllers;

use Yii;
use app\models\Userprofile;
use app\models\UserprofileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserprofileController implements the CRUD actions for Userprofile model.
 */
class UserprofileController extends Controller
{
    public function behaviors()
    {
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
     * Lists all Userprofile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $profile = Userprofile::find()->where("user_id='".Yii::$app->user->id."'")->one();
        return $this->render('view', [
            'model' => $profile,
        ]);
    }


    
    /**
     * Updates an existing Userprofile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = Userprofile::find()->where("user_id='".Yii::$app->user->id."'")->one();
        
        if(!$model){            
            $model = new Userprofile();    
            $model->scenario = "create";
        }
        
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            $model->image = \yii\web\UploadedFile::getInstance($model, 'image');
            if ($model->image) {              
                @unlink(Yii::$app->params["profileImagePathOs"].Userprofile::find()->where("user_id='".Yii::$app->user->id."'")->one()->image);
                $name = uniqid() . '.' . $model->image->extension;;
                $model->image->saveAs(Yii::$app->params["profileImagePathOs"] . $name);
                $model->image = $name;                
            } else {
                $model->image = Userprofile::find()->where("user_id='".Yii::$app->user->id."'")->one()->image;
            }
            
            if($model->save()){
                Yii::$app->getSession()->setFlash('success' , 'Your profile has been updated.');
                return $this->redirect(['index']);
            } 
            
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    

    /**
     * Finds the Userprofile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Userprofile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Userprofile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionChangepassword(){
        $model = new \app\models\ChangePassword();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->changePassword()) {
                Yii::$app->getSession()->setFlash('success', 'Your password changed');
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to change password.');
            }
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }
}
