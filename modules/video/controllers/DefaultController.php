<?php

namespace app\modules\video\controllers;

use yii\web\Controller;
use Yii;
/**
 * Default controller for the `video` module
 */
class DefaultController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        
        
        $searchModel = new \app\models\LmsVideoSearch();
        $searchModel->created_by = Yii::$app->user->id;
        $searchModel->status = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
                    
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
        
    }

    public function actionCreate() {

        return $this->render("create");
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if($model->load(Yii::$app->request->post()) && $model->save()){
            Yii::$app->session->setFlash("success","Video Content Updated");
            return $this->redirect(\yii\helpers\Url::to(['/video/default/index'],true));
        }
        return $this->render("update",['model' => $model]);
    }
    
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
        if (($model = \app\models\LmsVideo::findOne(['id' => $id, 'created_by' => Yii::$app->user->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSaveVideo() {
        $msg = "";
        $status = 0;
        if (!isset($_POST['audio-filename']) && !isset($_POST['video-filename'])) {            
            return json_encode(['msg' => "Empty file name.", 'status' => 0]);
        }

        // do NOT allow empty file names
        if (empty($_POST['audio-filename']) && empty($_POST['video-filename'])) {            
            return json_encode(['msg' => 'Empty file name.','status' =>0]);
        }

        // do NOT allow third party audio uploads
        if (false && isset($_POST['audio-filename']) && strrpos($_POST['audio-filename'], "RecordRTC-") !== 0) {
            
            return json_encode(['msg' => 'File name must start with "RecordRTC-"', 'status' => 0]);
        }

        // do NOT allow third party video uploads
        if (false && isset($_POST['video-filename']) && strrpos($_POST['video-filename'], "RecordRTC-") !== 0) {
            
            return json_encode(['msg' => 'File name must start with "RecordRTC-"','status' => 0]);
        }

        $fileName = '';
        $tempName = '';
        $file_idx = '';

        if (!empty($_FILES['audio-blob'])) {
            $file_idx = 'audio-blob';
            $fileName = $_POST['audio-filename'];
            $tempName = $_FILES[$file_idx]['tmp_name'];
        } else {
            $file_idx = 'video-blob';
            $fileName = $_POST['video-filename'];
            $tempName = $_FILES[$file_idx]['tmp_name'];
        }

        if (empty($fileName) || empty($tempName)) {
            if (empty($tempName)) {
                
                return json_encode(['msg' => 'Invalid temp_name: ' . $tempName, 'status' => 0]);
            }

            
            return json_encode(['msg' => 'Invalid file name: ' . $fileName, 'status' => 0]);
        }

        /*
          $upload_max_filesize = return_bytes(ini_get('upload_max_filesize'));

          if ($_FILES[$file_idx]['size'] > $upload_max_filesize) {
          echo 'upload_max_filesize exceeded.';
          return;
          }

          $post_max_size = return_bytes(ini_get('post_max_size'));

          if ($_FILES[$file_idx]['size'] > $post_max_size) {
          echo 'post_max_size exceeded.';
          return;
          }
         */

        $filePath = Yii::$app->params['videoPathOs'] . $fileName;

        // make sure that one can upload only allowed audio/video files
        $allowed = array(
            'webm',
            'wav',
            'mp4',
            'mkv',
            'mp3',
            'ogg'
        );
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        if (!$extension || empty($extension) || !in_array($extension, $allowed)) {
            
            return json_encode(['msg' => 'Invalid file extension: ' . $extension, 'status' => 0]);
        }

        if (!move_uploaded_file($tempName, $filePath)) {
            if (!empty($_FILES["file"]["error"])) {
                $listOfErrors = array(
                    '1' => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                    '2' => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
                    '3' => 'The uploaded file was only partially uploaded.',
                    '4' => 'No file was uploaded.',
                    '6' => 'Missing a temporary folder. Introduced in PHP 5.0.3.',
                    '7' => 'Failed to write file to disk. Introduced in PHP 5.1.0.',
                    '8' => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.'
                );
                $error = $_FILES["file"]["error"];

                if (!empty($listOfErrors[$error])) {
                    $msg = $listOfErrors[$error];
                } else {
                    $msg = 'Not uploaded because of error #' . $_FILES["file"]["error"];
                }
            } else {
                $msg .= '\nProblem saving file: ' . $tempName;
            }
            return json_encode(['msg' => $msg, 'status' => 0]);
        }

        $model = new \app\models\LmsVideo();
        $model->class_id = Yii::$app->request->post('class_id');
        $model->subject_id = Yii::$app->request->post('subject_id');
        $model->filename = $fileName;
        $model->title = Yii::$app->request->post('title',date('Y-m-d H:i'));
        if(!$model->save()){
            \app\components\GeneralHelper::getErrorAsString($model);
        } else {
            return json_encode(['msg' => 'success', 'status' => 1]);
        }
    }

}
