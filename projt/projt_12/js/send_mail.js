$(function() {

$(".sendmail").live("click",function () {
    if($("#sendmail_content").html() != '') {
        if (typeof sendmail_focus === "undefined" || sendmail_focus) $.scrollTo("#sendmail_content",800);
        return false;
    }
    else {
        if ($(this).attr('data-bbs_id')) {
            $.get("/send_mail.php", { action: 'send',id: $(this).attr('data-bbs_id') },
                function(data){
                $("#sendmail_content").append(data);
                if (typeof sendmail_focus === "undefined" || sendmail_focus) $.scrollTo("#sendmail_content",800);
            });
        }
        else if ($(this).attr('data-comment_id'))  {
            $.get("/send_mail.php", { action: 'send',comment_id: $(this).attr('data-comment_id') },
                function(data){
                $("#sendmail_content").append(data);
                $.scrollTo("#sendmail_content",800);
            });
        }
        else return false;
    }
});

$('#sendmail_sub').live("click", function () {
    var fio = $('#send_fio').val();
    var email = $('#send_email').val();
    var captcha = $('#send_captcha').val();
    var msg = $('#send_msg').val();
    var topic = $('#send_topic').val();
    if ($(this).attr('data-bbs_id')) {
    $.post("/send_mail.php", { action: 'sub_send',id: $(this).attr('data-bbs_id'),from_fio: fio, from_email: email,msg: msg,img: captcha  },
        function(data){
            if ($.trim(data) != "ok") {
            $("#send_error").html(data);
        }
        else {
            $("#sendmail_content").html('');
            alert('Сообщение успешно доставлено');
            $(window).scrollTo(0,800);
        }
    });
    }
    else if ($(this).attr('data-comment_id')) {
    $.post("/send_mail.php", { action: 'sub_send',comment_id: $(this).attr('data-comment_id'),from_fio: fio, from_email: email,msg: msg,img: captcha,topic: topic  },
        function(data){
            if ($.trim(data) != "ok") {
            $("#send_error").html(data);
        }
        else {
            $("#sendmail_content").html('');
            alert('Сообщение успешно доставлено');
            $(window).scrollTo(0,800);
        }
    });
    }
    else return false;
});
});