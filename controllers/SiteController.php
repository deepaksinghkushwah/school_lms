<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;

class SiteController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client) {
        (new \app\components\AuthHandler($client))->handle();
    }

    public function actionIndex() {

        return $this->render('index');
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if (isset($_GET['regtoken']) and $_GET['regtoken'] != '') {

            $regkey = trim($_GET['regtoken']);
            $data = $model->getregkey($regkey);

            if ($data != '' and $data['status'] == '10') {
                Yii::$app->session->setFlash('success', 'Your account has been activated now');
            }
            //$this->goHome();
        }


        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(\app\models\Setting::findOne(['key' => 'admin_email'])->value)) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    public function actionAbout() {
        return $this->render('about');
    }

    public function actionSignup() {
        $model = new SignupForm();
        $profile = new \app\models\Userprofile();
        $profile->scenario = 'create';
        if ($model->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {

            if ($user = $model->signup(0, $profile)) {
                //if (Yii::$app->getUser()->login($user)) {
                $this->sendregistrationMail($user, $model->password);
                Yii::$app->getSession()->setFlash('success', 'You are registered successfully, please check your mail for further instructions.');
                return $this->goHome();
                //}
            }
        }

        return $this->render('signup', [
                    'model' => $model,
                    'profile' => $profile,
        ]);
    }

    function sendregistrationMail($user, $password) {
        $mail = Yii::$app->mailer->compose(['html' => 'registermail'], ['user' => $user, 'password' => $password]);
        $sub = Yii::$app->name . ' user registration';
        $mail->setTo($user->email);
        $mail->setFrom(Yii::$app->params['settings']['admin_email']);
        $mail->setSubject($sub);
        $data = $mail->send();

        if ($data == true) {
            Yii::$app->session->setFlash('success', 'Thank you for register with us! Login details with an activation link has been sent to your mail id to activate your account.');
        } else {
            Yii::$app->session->setFlash('error', 'Error at sending mail please try again.');
        }
    }

    public function actionRequestPasswordReset() {
        $model = new \app\models\PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    public function actionResetPassword($token) {
        try {
            $model = new \app\models\ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    

    public function actionImage() {
        \app\components\timthumb::start();
        Yii::$app->exit;
    }

    

    public function actionNews() {
        $model = \app\models\Page::find();
        $model->where("status = '1' AND category_id = 3 ");
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('news', ['dataProvider' => $dataProvider]);
    }
    
    public function actionGetCounties(){
        $countryId = Yii::$app->request->get('country_id');
        $model = \app\models\GeoState::findAll(['country_id' => $countryId]);
        $arr[] = ['id' => '0','name' => 'Select Any'];
        if($model){
            foreach($model as $row){
                $arr[] = ['id' => $row->id, 'name' => $row->name];
            }
        }
        return json_encode(['items' => $arr]);
    }
    
    public function actionGetCities(){
        $countyId = Yii::$app->request->get('county_id');
        $model = \app\models\GeoCity::findAll(['state_id' => $countyId]);
        $arr[] = ['id' => '0','name' => 'Select Any'];
        if($model){
            foreach($model as $row){
                $arr[] = ['id' => $row->id, 'name' => $row->name];
            }
        }
        return json_encode(['items' => $arr]);
    }
    
    public function actionPage($alias) {
        //echo "<pre>";print_r($_REQUEST);echo "</pre>";
        $alias = Yii::$app->request->get('alias', '');
        $model = \app\models\Page::find()->where("alias='$alias'")->one();

        $newCommentModel = new \app\models\Comment();
        $newRatingModel = new \app\models\PageRating();

        if ($newRatingModel->load(Yii::$app->request->post())) {
            $newRatingModel2 = \app\models\PageRating::findOne(['page_id' => $model->id, 'user_id' => Yii::$app->user->id]);
            if (!$newRatingModel2) {
                $newRatingModel2 = clone $newRatingModel;
            }
            $newRatingModel2->page_id = $model->id;
            $newRatingModel2->rating = $newRatingModel->rating;
            $newRatingModel2->user_id = Yii::$app->user->id;
            if ($newRatingModel2->save()) {
                Yii::$app->session->setFlash('success', 'Your rating has been saved!');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('danger', 'You must select a rating scale');
            }
        }


        if ($newCommentModel->load(Yii::$app->request->post())) {
            $newCommentModel->user_id = isset(Yii::$app->user->id) ? Yii::$app->user->id : NULL;
            $newCommentModel->page_id = $model->id;
            $newCommentModel->created_at = date('Y-m-d H:i:s');
            if ($newCommentModel->save()) {
                Yii::$app->session->setFlash('success', 'Thank you for writing comment. Your comment will be shows after review by moderator!');
                return $this->refresh();
            }
        }


        return $this->render('page', ['model' => $model, 'newCommentModel' => $newCommentModel, 'newRatingModel' => $newRatingModel]);
    }

   

    public function actionDownloadFile($id) {
        $a = \app\models\PageAttachment::findOne(['id' => $id]);
        $file = Yii::$app->params['attachmentPathOs'] . $a->filename;

        if (!is_readable($file)) {
            die('File not found or inaccessible!');
        }
        $size = filesize($file);
        $name = $a->filename;
        $name = rawurldecode($name);
        $known_mime_types = array(
            "htm" => "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            
            "jpg" => "image/jpg",
            "php" => "text/plain",
            
            "doc" => "application/msword",
            'docs' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            "xls" => "application/vnd.ms-excel",
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',            
            "ppt" => "application/vnd.ms-powerpoint",
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            
            "gif" => "image/gif",
            "pdf" => "application/pdf",
            "txt" => "text/plain",
            "html" => "text/html",
            "png" => "image/png",
            "jpeg" => "image/jpg"
        );

        //if ($mime_type == '') {
        $file_extension = strtolower(substr(strrchr($file, "."), 1));
        if (array_key_exists($file_extension, $known_mime_types)) {
            $mime_type = $known_mime_types[$file_extension];
        } else {
            $mime_type = "application/force-download";
        };
        //};
        @ob_end_clean();
        if (ini_get('zlib.output_compression'))
            ini_set('zlib.output_compression', 'Off');
        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header("Content-Transfer-Encoding: binary");
        header('Accept-Ranges: bytes');

        if (isset($_SERVER['HTTP_RANGE'])) {
            list($a, $range) = explode("=", $_SERVER['HTTP_RANGE'], 2);
            list($range) = explode(",", $range, 2);
            list($range, $range_end) = explode("-", $range);
            $range = intval($range);
            if (!$range_end) {
                $range_end = $size - 1;
            } else {
                $range_end = intval($range_end);
            }

            $new_length = $range_end - $range + 1;
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $new_length");
            header("Content-Range: bytes $range-$range_end/$size");
        } else {
            $new_length = $size;
            header("Content-Length: " . $size);
        }

        $chunksize = 1 * (1024 * 1024);
        $bytes_send = 0;
        if ($file = fopen($file, 'r')) {
            if (isset($_SERVER['HTTP_RANGE']))
                fseek($file, $range);

            while (!feof($file) &&
            (!connection_aborted()) &&
            ($bytes_send < $new_length)
            ) {
                $buffer = fread($file, $chunksize);
                echo($buffer);
                flush();
                $bytes_send += strlen($buffer);
            }
            fclose($file);
        } else
            die('Error - can not open file.');
        die();
    }
    
    public function actionDownloadContentFile($id) {
        $a = \app\models\LmsContentAttachment::findOne(['id' => $id]);
        $file = Yii::$app->params['contentAttachmentPathOs'] . $a->filename;

        if (!is_readable($file)) {
            die('File not found or inaccessible!');
        }
        $size = filesize($file);
        $name = $a->filename;
        $name = rawurldecode($name);
        $known_mime_types = array(
            "htm" => "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            
            "jpg" => "image/jpg",
            "php" => "text/plain",
            
            "doc" => "application/msword",
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            "xls" => "application/vnd.ms-excel",
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',            
            "ppt" => "application/vnd.ms-powerpoint",
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            
            "gif" => "image/gif",
            "pdf" => "application/pdf",
            "txt" => "text/plain",
            "html" => "text/html",
            "png" => "image/png",
            "jpeg" => "image/jpg"
        );

        //if ($mime_type == '') {
        $file_extension = strtolower(substr(strrchr($file, "."), 1));
        if (array_key_exists($file_extension, $known_mime_types)) {
            $mime_type = $known_mime_types[$file_extension];
        } else {
            $mime_type = "application/force-download";
        };
        //};
        @ob_end_clean();
        if (ini_get('zlib.output_compression'))
            ini_set('zlib.output_compression', 'Off');
        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header("Content-Transfer-Encoding: binary");
        header('Accept-Ranges: bytes');

        if (isset($_SERVER['HTTP_RANGE'])) {
            list($a, $range) = explode("=", $_SERVER['HTTP_RANGE'], 2);
            list($range) = explode(",", $range, 2);
            list($range, $range_end) = explode("-", $range);
            $range = intval($range);
            if (!$range_end) {
                $range_end = $size - 1;
            } else {
                $range_end = intval($range_end);
            }

            $new_length = $range_end - $range + 1;
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $new_length");
            header("Content-Range: bytes $range-$range_end/$size");
        } else {
            $new_length = $size;
            header("Content-Length: " . $size);
        }

        $chunksize = 1 * (1024 * 1024);
        $bytes_send = 0;
        if ($file = fopen($file, 'r')) {
            if (isset($_SERVER['HTTP_RANGE']))
                fseek($file, $range);

            while (!feof($file) &&
            (!connection_aborted()) &&
            ($bytes_send < $new_length)
            ) {
                $buffer = fread($file, $chunksize);
                echo($buffer);
                flush();
                $bytes_send += strlen($buffer);
            }
            fclose($file);
        } else
            die('Error - can not open file.');
        die();
    }

    public function actionClearCache() {
        $cacheDirPath = Yii::getAlias('@webroot').'/assets';
        
        if ($this->destroy_dir($cacheDirPath, 0)) {
            Yii::$app->session->setFlash('success', 'Cache cleared.');
        }
        return $this->redirect(\yii\helpers\Url::to(['/site/index']));
    }

    private function destroy_dir($dir, $i = 1) {
        if (!is_dir($dir) || is_link($dir))
            return unlink($dir);
        foreach (scandir($dir) as $file) {
            if ($file == '.' || $file == '..')
                continue;
            if (!$this->destroy_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                chmod($dir . DIRECTORY_SEPARATOR . $file, 0777);
                if (!$this->destroy_dir($dir . DIRECTORY_SEPARATOR . $file))
                    return false;
            };
        }
        if ($i == 1)
            return rmdir($dir);
        return true;
    }

    

}
