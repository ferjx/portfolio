$(function() {
$("#bbslike,#bbslike_text").live("click",function () {
    $.post("/bbslike.php", { bbs_id: $(this).attr('data-bbs_id')},
    function(data){
            if (data.error !== undefined) {
                $("#bbslike_error").html(data.error);
            }
            else if (data.added !== undefined) {
                $("#bbslike_error").html("");
                $("#bbslike").html("<img src='"+img_remove_like+"'>");
                $("#bbslike_text").html(remove_like_text);
                if (data.added == 2) {
                    $("#bbslike_error").html("<a href='"+like_help_link+"'>");
                }
            }
            else if (data.deleted !== undefined) {
                $("#bbslike_error").html("");
                $("#bbslike").html("<img src='"+img_add_like+"'>");
                $("#bbslike_text").html(add_like_text);
            }
    },
    'json');

    return false;
});
});