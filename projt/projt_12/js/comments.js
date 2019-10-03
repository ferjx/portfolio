$(function() {
    $(".comment_link").live("click",function () {
        var cit;
        var edit;
        if($("#comment_content").html() != '') {
            $("#comment_content").html("");
        }

        if ($(this).attr('data-cit').length > 0) cit = $(this).attr('data-cit');
        else cit = 0;
        if ($(this).attr('data-edit').length > 0) edit = $(this).attr('data-edit');
        else edit = 0;
        $.get("/comments.php", { action: 'comment',id: $(this).attr('data-bbs_id'),cit: cit,edit: edit },
        function(data){
                $("#comment_content").append(data);
                $.scrollTo("#comment_content",800);
        });
    });

    $('#show_more_comments').click(function () {
        var el = $(this);
        var curr_page = parseInt(el.attr('data-curr_page'));
        $.get(el.attr('href'),
            function(ret){
                curr_page += 1;
                next_page = curr_page + 1;
                // prev_page = curr_page - 1;
                el.attr('data-curr_page', curr_page);
                newlink = el.attr('href').replace(/page[0-9]+/,"page"+next_page);
                el.attr('href', newlink);

                if (ret.msgs.length > 0) {
                    $('#comments').append("<small>- &nbsp;" + curr_page + "&nbsp; -</small>");
                    $.each(ret.msgs, function(key, msg) {
                        $('#comments').append(msg);
                    });
                }
                else {
                    el.hide();
                }

            }, "json");

        return false;
    });
});