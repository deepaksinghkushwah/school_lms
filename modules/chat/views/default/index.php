<?php
/* @var $this yii\web\View */
app\modules\chat\assets\DefaultIndexAsset::register($this);
$this->title = "Chat";

$teachers = \app\components\GeneralHelper::getUsersByRole("Teacher");
$students = \app\components\GeneralHelper::getUsersByRole("Student");

$this->registerJs('var teachers = ' . json_encode($teachers), $this::POS_BEGIN);
$this->registerJs('var students = ' . json_encode($students), $this::POS_BEGIN);
echo \yii\helpers\Html::hiddenInput("getMessageUrl", yii\helpers\Url::to(['/chat/default/get-message-list'], true), ['id' => 'getMessageUrl']);
echo \yii\helpers\Html::hiddenInput("saveMessageUrl", yii\helpers\Url::to(['/chat/default/save-message'], true), ['id' => 'saveMessageUrl']);
?>
<div class="chat-default-index">
    <h1><?= $this->title ?></h1><hr>
    <div id="app">
        <table class="table table-bordered">
            <tr>
                <td>
                    <h3>Teachers</h3>
                    <div class="userList">
                        <ul class="list-group">
                            <li @click="setToUser(user.id)" class="list-group-item" v-for="user in teachers"  v-bind:class="{active: toUser === user.id}">
                                <a href="javascript:void(0)" @click="setToUser(user.id)">{{ user.fullname }}</a>
                            </li>
                        </ul>
                    </div>
                    <h3>Students</h3>
                    <div class="userList">
                        <ul class="list-group">
                            <li @click="setToUser(user.id)" class="list-group-item" v-for="user in students"  v-bind:class="{active: toUser === user.id}">
                                <a href="javascript:void(0)" @click="setToUser(user.id)">{{ user.fullname }}</a>
                            </li>
                        </ul>
                    </div>
                </td>
                <td>

                    <div class="msgList" id="allMessages">
                        <span v-if="toUser == null">Please select any user from left to start chat</span>
                        <span v-if="helpText != ''">{{ helpText }}</span>
                        <ul ref="messagesContainer">
                            <li style="list-style-type: none; margin-bottom: 10px;" v-for="msg in messages" :key="msg.id">
                                <table class="table table-bordered">
                                    <tr>
                                        <th v-bind:class="{'text-right': msg.to_user_id == toUser, 'text-left': msg.to_user_id != toUser}">{{ msg.from }} {{ msg.created_at }}</th>
                                    </tr>
                                    <tr>
                                        <td v-bind:class="{'text-right': msg.to_user_id == toUser, 'text-left': msg.to_user_id != toUser}">{{ msg.message }}</td>
                                    </tr>
                                </table>
                            </li>
                        </ul>
                        
                    </div>
                    
                    <div>
                        
                        <input @keyup.enter="sendMessage" v-model="txtMessage" type="text" class="form-control"/><br>
                        <div class="loadingImgContainer" class="d-flex flex-row-reverse">
                            <span v-if="isLoading == true"><?= yii\helpers\Html::img(\yii\helpers\Url::to(['/images/loader.gif'],true),['width' => '50px'])?></span>
                        </div>
                    </div>
                </td>
            </tr>

        </table>
    </div>
</div>
