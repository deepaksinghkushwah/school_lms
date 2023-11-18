<?php

namespace app\modules\student\controllers;

use yii\web\Controller;
use Yii;

/**
 * Default controller for the `student` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $purchasedClasses = \app\modules\student\components\StudentHelper::getStudentCourses(Yii::$app->user->id);
        return $this->render('index', ['courses' => $purchasedClasses]);
    }

    public function actionContentList() {
        $classID = Yii::$app->request->get('class_id');
        \app\modules\student\components\StudentHelper::checkCourseOwnership(Yii::$app->user->id, $classID);
        $class = \app\models\LmsMasterClass::findOne(['id' => $classID]);
        $searchModel = new \app\models\LmsContentSearch();
        $searchModel->class_id = $classID;
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];

        return $this->render('content-list', [
                    'classModel' => $class,
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionContentDetail() {
        $id = Yii::$app->request->get('id');
        $model = \app\models\LmsContent::findOne(['id' => $id]);
        \app\modules\student\components\StudentHelper::checkCourseOwnership(Yii::$app->user->id, $model->class_id);
        return $this->render('content-detail', ['model' => $model]);
    }

    public function actionExams() {
        $searchModel = new \app\models\LmsExamSearch();
        $classes = \app\modules\student\components\StudentHelper::getStudentCourses(Yii::$app->user->id);
        if ($classes) {
            foreach ($classes as $c) {
                $class[] = $c['id'];
            }
            $searchModel->classesIds = $class;
        } else {
            $searchModel->classesIds = [0];
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];

        return $this->render('exams', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTakeExam($exam_id) {
        $exam = \app\models\LmsExam::findOne(['id' => $exam_id]);
        \app\modules\student\components\StudentHelper::checkCourseOwnership(Yii::$app->user->id, $exam->class_id);
        return $this->render('take-exam', ['examId' => $exam_id]);
    }

    public function actionSaveResult() {
        $examId = Yii::$app->request->get('exam_id');
        $createdAt = date('Y-m-d H:i');
        $attemptId = (string) \Ramsey\Uuid\Uuid::uuid4(); //bin2hex(random_bytes(32)); //\Ramsey\Uuid\Uuid::uuid4();
        $answers = Yii::$app->request->get('answers');
        if (count($answers) > 0) {
            $mrs = new \app\models\LmsStudentResultMain();
            $mrs->student_id = Yii::$app->user->id;
            $mrs->exam_id = $examId;
            $mrs->exam_total_score = (new \app\models\LmsExam)->getScore($examId);
            $mrs->attempt_id = $attemptId;
            $mrs->score = 0.00;
            $mrs->created_at = date('Y-m-d H:i');
            $mrs->teacher_id = \app\models\LmsExam::findOne($examId)->created_by;
            if (!$mrs->save()) {
                var_dump(\app\components\GeneralHelper::getErrorAsString($mrs));
                exit;
            }
            $totalScore = 0.00;
            foreach ($answers as $ans) {
                $questionId = $ans['qid'];
                $ansId = $ans['ans_id'];

                $q = \app\models\LmsQuestionBank::findOne(['id' => $questionId]);
                $eq = \app\models\LmsExamQuestion::findOne(['question_id' => $questionId]);
                $a = \app\models\LmsQuestionAnswerOption::findOne(['id' => $ansId]);

                $res = new \app\models\LmsStudentResult();
                $res->exam_id = $examId;
                $res->student_id = \Yii::$app->user->id;
                $res->question_id = $questionId;
                $res->question_text = $q->question_text;
                $res->question_score = $eq->score_point;
                $res->answer_id = $ansId;
                $res->answer_text = $a->answer_text;
                $res->created_at = $createdAt;
                $res->attempt_id = $attemptId;

                if ($a->is_correct_answer) {
                    $res->correct_answer_id = $ansId;
                    $res->correct_answer_text = $a->answer_text;
                } else {
                    $ca = \app\models\LmsQuestionAnswerOption::findOne(['question_id' => $questionId, 'is_correct_answer' => 1]);
                    $res->correct_answer_id = $ca->id;
                    $res->correct_answer_text = $ca->answer_text;
                }
                $leq = \app\models\LmsExamQuestion::findOne(['exam_id' => $examId, 'question_id' => $questionId]);
                if ($leq && $a->is_correct_answer) {
                    $score = $leq->score_point;
                    $totalScore += $leq->score_point;
                } else {
                    $score = 0;
                }
                $res->score = $score;
                if (!$res->save()) {
                    echo "<pre>";
                    print_r($res->getErrors());
                    echo "</pre>";
                }
            }
            $mrs->score = $totalScore;
            $mrs->save();
        }
        //exit($attemptId);
        $url = \yii\helpers\Url::to(['/student/default/show-result', 'exam_id' => $examId, 'attempt_id' => $attemptId], true);
        return json_encode(['msg' => 'Exam completed', 'return_url' => $url]);
    }

    public function actionShowResult() {
        $examId = Yii::$app->request->get('exam_id');
        $attemptId = Yii::$app->request->get('attempt_id');
        $exam = \app\models\LmsExam::findOne(['id' => $examId]);
        $answers = \app\models\LmsStudentResult::findAll(['attempt_id' => $attemptId, 'student_id' => Yii::$app->user->id]);
        $resultMain = \app\models\LmsStudentResultMain::findOne(['attempt_id' => $attemptId]);
        return $this->render('view-result', ['examId' => $examId, 'attemptId' => $attemptId, 'answers' => $answers, 'exam' => $exam, 'resultMain' => $resultMain]);
    }

    public function actionAllResults() {

        $searchModel = new \app\models\LmsStudentResultSearch();
        if (Yii::$app->request->get('exam_id', 0) > 0) {
            $searchModel->exam_id = Yii::$app->request->get('exam_id');
        }
        $searchModel->student_id = Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];
        /* $dataProvider->pagination = [
          'pageSize' => 20
          ]; */

        return $this->render('all-results', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionSearch() {
        $q = trim(Yii::$app->request->get('q'));
        if ($q != "") {
            $query = \app\models\LmsContent::find()->where("content OR title like '%$q%' ")->groupBy(['id'])->orderBy(['updated_at' => SORT_DESC]);
            $countQuery = clone $query;
            $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count(), 'pageSize' => Yii::$app->params['settings']['record_per_page']]);

            $result = $query->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();
            return $this->render('content-search', ['model' => $result, 'q' => $q, 'pages' => $pages, 'total' => $countQuery->count()]);
        } else {
            return $this->render('content-search', ['model' => [], 'q' => $q, 'total' => 0]);
        }
    }

    public function actionGenerateCert() {
        $this->layout = "empty";
        $attemptID = Yii::$app->request->get('id');
        $result = \app\models\LmsStudentResultMain::findOne(['attempt_id' => $attemptID, 'student_id' => Yii::$app->user->id]);
        $content = $this->render('certificate', [
            'name' => $result->student->profile->fullname,
            'courseName' => $result->exam->title,
            'grade' => (($result->score * 100) / $result->exam_total_score),
            'examDate' => date('l m Y', strtotime($result->created_at))
        ]);
        $pdf = Yii::$app->pdf;
        $pdf->content = $content;
        return $pdf->render();
    }

    public function actionVideoList() {
        $searchModel = new \app\models\LmsVideoSearch();
        \app\modules\student\components\StudentHelper::checkCourseOwnership(Yii::$app->user->id, Yii::$app->request->get('class_id'));
        if (isset($_REQUEST['LmsVideoSearch']['class_id']) && $_REQUEST['LmsVideoSearch']['class_id'] != '') {
            //exit($_REQUEST['LmsVideoSearch']['class_id']);
            \app\modules\student\components\StudentHelper::checkCourseOwnership(Yii::$app->user->id, $_REQUEST['LmsVideoSearch']['class_id']);
        }
        $searchModel->class_id = Yii::$app->request->get('class_id');
        $searchModel->status = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('video-list', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionVideoView($id) {
        $model = \app\models\LmsVideo::findOne($id);
        \app\modules\student\components\StudentHelper::checkCourseOwnership(Yii::$app->user->id, $model->class_id);
        return $this->render('video-view', ['model' => $model]);
    }
    
    public function actionVideoCommentCreate(){        
        $model = new \app\models\LmsVideoComment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($model->parent_id == 0){
                Yii::$app->session->setFlash("success","Your question added");
            } else {
                Yii::$app->session->setFlash("success","Your comment added");
            }
            
            return $this->redirect(\yii\helpers\Url::to(['/student/default/video-view','id' => $model->video_id],true));
        }
    }

}
