$(function() {
    Share = {
        vkontakte: function(purl, ptitle, pimg, text, uid) {
            url  = 'https://vkontakte.ru/share.php?';
            url += 'url='          + purl;
            url += '&title='       + ptitle;
            url += '&description=' + text;
            url += '&image='       + pimg;
            url += '&noparse=true';
            Share.popup('vkontakte', url, uid);
        },
        odnoklassniki: function(purl, text, pimg, uid) {
            url  = 'https://connect.ok.ru/offer';
            url += '?url=' + purl;
            url += '&title=' + text;
            url += '&imageUrl=' + pimg;
            Share.popup('odnoklassniki', url, uid);
        },
        facebook: function(purl, ptitle, pimg, text, uid) {
            url  = 'http://www.facebook.com/sharer.php?s=100';
            url += '&p[title]='     + ptitle;
            url += '&p[summary]='   + text;
            url += '&p[url]='       + purl;
            url += '&p[images][0]=' + pimg;
            Share.popup('facebook', url, uid);
        },
        twitter: function(purl, ptitle, uid) {
            url  = 'http://twitter.com/share?';
            url += 'text='      + ptitle;
            url += '&url='      + purl;
            url += '&counturl=' + purl;
            Share.popup('twitter', url, uid);
        },
        mailru: function(purl, ptitle, pimg, text, uid) {
            url  = 'http://connect.mail.ru/share?';
            url += 'url='          + purl;
            url += '&title='       + ptitle;
            url += '&description=' + text;
            url += '&imageurl='    + pimg;
            // url += '&utm_source=share2';
            Share.popup('mailru', url, uid);
        },

        popup: function(soc, url, uid) {
            $.post('//kupiprodai.ru/socshare', {social:soc, page:url, uid:uid, url:window.location.href}, function (data){});
            window.open(url,'','toolbar=0,status=0,width=626,height=436');
        }
    };
});