<?php

namespace app\modules\email\controllers;

use yii\web\Controller;
use app\models\Mailing;
use app\models\MailingSearch;
use yii\filters\VerbFilter;
use Yii;
/**
 * Default controller for the `email` module
 */
class DefaultController extends Controller
{
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
     * Lists all Mailing models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new MailingSearch();        
        $searchModel->to_user = Yii::$app->user->id;
        $searchModel->status = [0, 1];                
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => [
                'id' => SORT_DESC
        ]];
        
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mailing model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $model = Mailing::findOne(['id' => $id, 'to_user' => Yii::$app->user->id]);
        if ($model) {
            $model->status = 1;
            $model->save();
            return $this->render('view', [
                        'model' => $model
            ]);
        } else {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Mailing model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Mailing();

        if ($model->load(Yii::$app->request->post())) {

            if (count($model->to_user) > 0) {
                foreach ($model->to_user as $to) {
                    $nm = new Mailing();
                    $nm->subject = $model->subject;
                    $nm->message = $model->message;
                    $nm->parent_id = 0;
                    $nm->from_user = Yii::$app->user->id;
                    $nm->to_user = $to;
                    if (!$nm->save()) {
                        echo "<pre>";
                        print_r($nm->getErrors());
                        echo "</pre>";
                        exit;
                    } else {
                        Yii::$app->session->setFlash("success", "Mail send to selected user(s)");
                    }
                }
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    

    /**
     * Deletes an existing Mailing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->status = 2;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Mailing model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mailing the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Mailing::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionReply() {
        $source = Mailing::findOne(['id' => Yii::$app->request->get('id')]);
        $model = new Mailing;
        $model->subject = "Re: " . $source->subject;
        $model->to_user = $source->from_user;
        $model->from_user = Yii::$app->user->id;
        $model->parent_id = $source->id;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['index']);
            } else {
                echo "<pre>";
                print_r($model->getErrors());
                echo "</pre>";
                exit;
            }
        }
        return $this->render('reply', ['model' => $model]);
    }

    public function actionTrash() {
        $searchModel = new MailingSearch();
        $searchModel->to_user = Yii::$app->user->id;
        $searchModel->status = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => [
                'id' => SORT_DESC
        ]];
        return $this->render('trash', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTrashView($id) {
        
        $model = $this->findModel($id);
        return $this->render('trash-view', [
                    'model' => $model
        ]);
    }
    
    public function actionSent() {
        $searchModel = new MailingSearch();
        $searchModel->from_user = Yii::$app->user->id;
        $searchModel->status = [0,1];
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => [
                'id' => SORT_DESC
        ]];
        return $this->render('sent', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSentView($id) {
        
        $model = $this->findModel($id);
        return $this->render('sent-view', [
                    'model' => $model
        ]);
    }
}
