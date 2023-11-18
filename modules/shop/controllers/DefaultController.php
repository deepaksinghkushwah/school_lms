<?php

namespace app\modules\shop\controllers;

use yii\web\Controller;
use Yii;

/**
 * Default controller for the `shop` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex() {
        $model = \app\models\LmsMasterClass::find()->all();
        return $this->render('index', ['model' => $model]);
    }

    public function actionAddToCart() {
        $classID = Yii::$app->request->get('id');
        $cart = \app\models\PaymentCart::findOne(['created_by' => Yii::$app->user->id, 'item_id' => $classID]);
        if(Yii::$app->user->can("Teacher")){
            Yii::$app->session->setFlash("danger", "Teachers don't need to purchase any course.");
            return $this->redirect(\yii\helpers\Url::to(['/shop/default/index'], true));
        }
        if (\app\modules\shop\components\ShopHelper::checkStudentOwnCourse(Yii::$app->user->id, $classID)) {
            Yii::$app->session->setFlash("warning", "You already owned this course");
            return $this->redirect(\yii\helpers\Url::to(['/shop/default/index'], true));
        }

        if (!$cart) {
            $cart = new \app\models\PaymentCart();
            $class = \app\models\LmsMasterClass::findOne($classID);
            $cart->item_id = $classID;
            $cart->item_price = $class->price;
            $cart->item_qty = 1;
            $cart->item_title = $class->title;
            $cart->save();
            Yii::$app->session->setFlash("info", "Item added in cart");
        } else {
            Yii::$app->session->setFlash("info", "Item already in cart");
        }
        return $this->redirect(\yii\helpers\Url::to(['/shop/default/cart'], true));
    }

    public function actionCart() {
        return $this->render('cart');
    }

    public function actionRemoveCartItem() {
        $item = \app\models\PaymentCart::findOne(['id' => Yii::$app->request->get('id'), 'created_by' => Yii::$app->user->id]);
        if ($item) {
            $item->delete();
            Yii::$app->session->setFlash("success", "Item removed from cart");
        } else {
            Yii::$app->session->setFlash("danger", "No item found");
        }
        return $this->redirect(\yii\helpers\Url::to(['/shop/default/cart'], true));
    }

}
