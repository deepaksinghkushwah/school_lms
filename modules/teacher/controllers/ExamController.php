<?php

namespace app\modules\teacher\controllers;

use Yii;
use app\models\LmsExam;
use app\models\LmsExamSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExamController implements the CRUD actions for LmsExam model.
 */
class ExamController extends Controller {

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
     * Lists all LmsExam models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new LmsExamSearch();
        $searchModel->created_by = Yii::$app->user->id;
        
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];
        
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LmsExam model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /* public function actionView($id)
      {
      return $this->render('view', [
      'model' => $this->findModel($id),
      ]);
      } */

    /**
     * Creates a new LmsExam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new LmsExam();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing LmsExam model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LmsExam model.
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
     * Finds the LmsExam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LmsExam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = LmsExam::findOne(['id' => $id, 'created_by' => Yii::$app->user->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionManageQuestion($exam_id) {
        $this->layout = "empty";
        $searchModel = new \app\models\LmsExamQuestionSearch();
        $searchModel->exam_id = $exam_id;
        $searchModel->created_by = Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];

        return $this->render('__manage_question', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddQuestion($exam_id) {
        $this->layout = "empty";
        $model = LmsExam::findOne(['id' => $exam_id]);
        $searchModel = new \app\models\LmsQuestionBankSearch();
        $searchModel->subject_id = $model->subject_id;
        $searchModel->class_id = $model->class_id;
        $searchModel->status = 1;



        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];
        //$dataProvider->pagination = ['pageSize' => 10];



        return $this->render('__add_question', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'examModel' => $model
        ]);
    }

    public function actionAddQuestionToExam() {
        $qid = Yii::$app->request->get('qid');
        $examId = Yii::$app->request->get('exam_id');
        $score = Yii::$app->request->get('score');

        $model = \app\models\LmsExamQuestion::findOne(['exam_id' => $examId, 'question_id' => $qid]);
        if (!$model) {
            $model = new \app\models\LmsExamQuestion();
            $model->exam_id = $examId;
            $model->question_id = $qid;
            $model->score_point = $score;
            if ($model->save()) {
                $msg = "Question added to exam";
            } else {
                print_r($model->getErrors());
                $msg = "Getting some technical issues adding this question to exam";
            }
        } else {
            $msg = "Question is already in this exam, please choose another";
        }
        return json_encode(['msg' => $msg]);
    }

    public function actionDeleteExamQuestion() {
        $model = \app\models\LmsExamQuestion::findOne(['id' => Yii::$app->request->get('row_id')]);
        if ($model) {
            $model->delete();
        }
        return json_encode(['msg' => 'Question removed']);
    }

    public function actionUpdateExamQuestionScore() {
        $rowId = Yii::$app->request->get('row_id');
        $score = Yii::$app->request->get('score_point');
        $sortOrder = Yii::$app->request->get('sort_order');
        $model = \app\models\LmsExamQuestion::findOne(['id' => $rowId]);
        $model->score_point = $score;
        $model->sort_order = $sortOrder;
        $model->save();
        return json_encode(['msg' => 'Score Updated']);
    }

    public function actionStudentsExamResult($exam_id) {
        $this->layout = 'empty';
        $searchModel = new \app\models\LmsStudentResultMainSearch();
        $searchModel->teacher_id = Yii::$app->user->id;
        $searchModel->exam_id = $exam_id;
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];
        
        $examStudents = \yii\helpers\ArrayHelper::map(\app\models\Userprofile::find()->where("user_id IN (SELECT student_id FROM lms_student_result_main WHERE exam_id = '$exam_id')")->orderBy(['fullname' => SORT_ASC])->all(),'user_id','fullname');
        return $this->render('students-exam-result', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
            'examStudents' => $examStudents,
            'examId'=> $exam_id
        ]);

        
    }

}
