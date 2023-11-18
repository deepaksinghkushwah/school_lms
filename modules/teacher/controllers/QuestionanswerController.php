<?php

namespace app\modules\teacher\controllers;

use Yii;
use app\models\LmsQuestionAnswerOption;
use app\models\LmsQuestionAnswerOptionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QuestionanswerController implements the CRUD actions for LmsQuestionAnswerOption model.
 */
class QuestionanswerController extends Controller
{
    public $layout = "empty";
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
     * Lists all LmsQuestionAnswerOption models.
     * @return mixed
     */
    public function actionIndex($qid)
    {
        $searchModel = new LmsQuestionAnswerOptionSearch();
        $searchModel->question_id = $qid;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'qid' => $qid
        ]);
    }

    /**
     * Displays a single LmsQuestionAnswerOption model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LmsQuestionAnswerOption model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($qid)
    {
        $model = new LmsQuestionAnswerOption();
        $model->question_id = $qid;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'qid' => $model->question_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'qid' => $qid
        ]);
    }

    /**
     * Updates an existing LmsQuestionAnswerOption model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index','qid' => $model->question_id]);
        }

        return $this->render('update', [
            'model' => $model,       
             'qid' => $model->question_id
        ]);
    }

    /**
     * Deletes an existing LmsQuestionAnswerOption model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $qid= $model->question_id;
        $model->delete();
        return $this->redirect(['index','qid' => $qid]);
    }

    /**
     * Finds the LmsQuestionAnswerOption model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LmsQuestionAnswerOption the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LmsQuestionAnswerOption::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
