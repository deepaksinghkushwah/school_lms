<?php

use ijackua\sharelinks\ShareLinks;
use \yii\helpers\Html;

/**
 * @var yii\base\View $this
 */
?>

<div class="socialShareBlock">

        <?= Html::a('<i class="fa fa-facebook"></i>', $this->context->shareUrl(ShareLinks::SOCIAL_FACEBOOK), ['title' => 'Share to Facebook', 'class' => 'btn btn-social-icon btn-facebook']) ?>
        <?= Html::a('<i class="fa fa-twitter"></i>', $this->context->shareUrl(ShareLinks::SOCIAL_TWITTER), ['title' => 'Share to Twitter', 'class' => 'btn btn-social-icon btn-twitter']) ?>
        <?= Html::a('<i class="fa fa-linkedin"></i>', $this->context->shareUrl(ShareLinks::SOCIAL_LINKEDIN), ['title' => 'Share to LinkedIn', 'class' => 'btn btn-social-icon btn-linkedin']) ?>
        <?= Html::a('<i class="fa fa-google"></i>', $this->context->shareUrl(ShareLinks::SOCIAL_GPLUS), ['title' => 'Share to Google Plus', 'class' => 'btn btn-social-icon btn-google']) ?>
        <?= Html::a('<i class="fa fa-vk"></i>', $this->context->shareUrl(ShareLinks::SOCIAL_VKONTAKTE), ['title' => 'Share to Vkontakte', 'class' => 'btn btn-social-icon btn-vk']) ?>
    <!--<?Html::a('<i class="icon-tablet"></i>', $this->context->shareUrl(ShareLinks::SOCIAL_KINDLE), ['title' => 'Send to Kindle','class' => 'btn btn-social-icon btn-facebook'])?>-->

</div>