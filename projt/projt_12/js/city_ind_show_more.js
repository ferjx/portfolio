$(function () {
    var counter = 1;
    $('#show_more').click(function () {
        var el = $(this);
        var curr_page = parseInt(el.attr('data-curr_pos'));
        $.get(el.attr('href'),
        function(ret){
            curr_page += 20;
            next_page = curr_page + 1;
            el.attr('data-curr_pos', curr_page);
            newlink = el.attr('href').replace(/\?from=[0-9]+/,"?from="+next_page);
            el.attr('href', newlink);

            if (ret.msgs.length > 0) {
                selector = (ret.is_mobile == 1) ? '#cat' : '#msgs_ind';
                counter++;
                $(selector).append("<small>- &nbsp;" + counter + "&nbsp; -</small>");
                $.each(ret.msgs, function(key, msg) {
                    $(selector).append(msg);
                });
            }
            else {
                el.hide();
            }

        }, "json");

        return false;
    });
});