$(function () {
    $('.users_messages_close, .users_messages_close_yellow').click(function () {
        var link = $(this);
        var message_name = link.attr('message_name');
        if (message_name == undefined || message_name == '') return false;
        $.get("/users/setting/"+message_name+'/0/',
        function(ret){
            if (ret.status == 0) alert(ret.data);
            else if (ret.data.res == 'ok') {
                link.parent().hide();
            }
            else {
                alert('Внутренняя ошибка');
            }
        }, "json");

        return false;
    });
});
