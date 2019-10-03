$(function() {
    $( "#spam_form" ).dialog({
        autoOpen:false,
        height:230,
        width:340,
        modal: true,
    });

    $( ".spam_link" ).live("click",function() {
            comment_id = $(this).attr('data-comment_id');
            $( "#spam_form" ).dialog( "open" );
        });

    $("#send_spam").click(function() {
        $.post("/spam.php", { action: 'spam',comment_id: comment_id,text: $('#spam_text').val()  },
        function(data){
        if ($.trim(data) != "ok") {
            alert(data);
        }
        else {
            $( "#spam_form" ).dialog( "close" );
            alert('Жалоба успешно отправлена');
        }
        });
    });

    $("#send_del_comment").click(function() {
        $.post("/spam.php", { action: 'del_comment',comment_id: comment_id },
            function(data){
                if ($.trim(data) != "ok") {
                    alert(data);
                }
                else {
                    $( "#spam_form" ).dialog( "close" );
                    alert('Комментарий удален');
                }
            });
        return false;
    });

    $("#send_del_all_comments").click(function() {
        $.post("/spam.php", { action: 'del_all_comments',comment_id: comment_id },
            function(data){
                if ($.trim(data) != "ok") {
                    alert(data);
                }
                else {
                    $( "#spam_form" ).dialog( "close" );
                    alert('Все комментарии удалены');
                }
            });
        return false;
    });
});