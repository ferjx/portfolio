$(function () {
    $('.auto_up_msg').click(function () {
        var href = $(this);
        var img = href.find('img');
        var bbs_id = $(this).attr('bbs_id');
        var activate = $(this).attr('activate');
        var auto_link = $(".auto_link[bbs_id='"+bbs_id+"']");
        $.get("/autoupmsg/"+bbs_id+'/'+activate+'/', {},
        function(ret){
            if (ret.status == 0) alert(ret.data);
            else if (ret.data.res == 'ok') {
                if (activate == 0) {
                    img.attr('src', '/images/upmsg/not_active.png');
                    href.attr('activate', 1);

                    auto_link.text('Автоподнятие');
                    auto_link.attr('href','/upauto/'+bbs_id+'/');

                    $('.auto_up_msg_all img').attr('src', '/images/upmsg/not_active.png');
                    $('.auto_up_msg_all').attr('activate', 1);
                }
                else {
                    if ((parseInt(ret.data.balans) > 0) || (parseInt(ret.data.balansautoup) > 0)) {
                        img.attr('src', '/images/upmsg/ok.png');
                        auto_link.text('Активно');
                        auto_link.attr('href','/upauto/'+bbs_id+'/');
                    }
                    else {
                        img.attr('src', '/images/upmsg/ok_no_balans.png');
                        auto_link.text('Оплатить');
                        auto_link.attr('href','/pay/autoup/');
                    }
                    href.attr('activate', 0);
                }
            }
            else {
                alert('Внутренняя ошибка');
            }
        }, "json");

        return false;
    });

    $('.auto_up_msg_all').click(function () {
        var href = $(this);
        var img = href.find('img');
        var activate = $(this).attr('activate');
        $.get("/autoupmsg/all/"+activate+'/', {},
            function(ret){
                if (ret.status == 0) alert(ret.data);
                else if (ret.data.res == 'ok') {
                    if (activate == 0) {
                        img.attr('src', '/images/upmsg/not_active.png');
                        href.attr('activate', 1);

                        $('.auto_up_msg img').attr('src', '/images/upmsg/not_active.png');
                        $('.auto_up_msg').attr('activate', 1);
                    }
                    else {
                        if ((parseInt(ret.data.balans) > 0) || (parseInt(ret.data.balansautoup) > 0)) {
                            img.attr('src', '/images/upmsg/ok.png');
                            $('.auto_up_msg img').attr('src', '/images/upmsg/ok.png');
                        }
                        else {
                            img.attr('src', '/images/upmsg/ok_no_balans.png');
                            $('.auto_up_msg img').attr('src', '/images/upmsg/ok_no_balans.png');
                        }
                        href.attr('activate', 0);
                        $('.auto_up_msg').attr('activate', 0);
                    }
                }
                else {
                    alert('Внутренняя ошибка');
                }
            }, "json");

        return false;
    });
});
