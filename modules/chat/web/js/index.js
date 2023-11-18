var vm = new Vue({
    el: '#app',
    data: {
        messages: [],
        teachers: teachers,
        students: students,
        txtMessage: '',
        toUser: null,
        helpText: "",
        isLoading: false,

    },
    created() {
        setInterval(this.fetchMessageForUser, 3000);
    },
    updated() {
        this.moveToBottom();
    },
    methods: {
        sendMessage() {
            var cl = this;
            if (this.toUser != null) {
                if (this.txtMessage != '') {
                    //this.messages.push(this.txtMessage);
                    $.ajax({
                        url: $('#saveMessageUrl').val(),
                        data: {to_user: cl.toUser, message: cl.txtMessage},
                        type: 'get',
                        dataType: 'json',
                        success: function (data) {
                            //console.log(data);                                  
                            cl.moveToBottom();
                        }
                    });
                    this.txtMessage = '';
                }
            } else {
                alert("Please select user from left panel");
            }
        },
        setToUser(userID) {
            this.toUser = userID;
            this.messages.length = 0;
        },
        fetchMessageForUser() {
            var cl = this;
            if (this.toUser != null) {
                $.ajax({
                    url: $('#getMessageUrl').val(),
                    data: {to_user: this.toUser},
                    type: 'get',
                    dataType: 'json',
                    beforeSend: function () {
                        cl.isLoading = true;
                    },
                    success: function (data) {
                        if (data.length > 0) {
                            cl.messages.length = 0;
                            $.each(data, function (index, item) {
                                cl.messages.push({
                                    id: item.id,
                                    message: item.message,
                                    to: item.to,
                                    to_user_id: item.to_user_id,
                                    from: item.from,
                                    created_at: item.created_at
                                });
                            });
                        } else {
                            cl.helpText = "No new message";
                        }
                        cl.isLoading = false;
                    },
                });

            }
            //$("#allMessages").animate({scrollTop: $('#allMessages').height()}, 1000); // animated

        },
        moveToBottom() {
            var container = this.$refs.messagesContainer;
            //console.log(container.scrollHeight);
            $('#allMessages').scrollTop(container.scrollHeight) // non animated             
        }

    }

});
