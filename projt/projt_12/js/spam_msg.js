// $(function() {
//     $( "#msg_spam_form" ).dialog({
//         autoOpen:false,
//         height:370,
//         width:340,
//         modal: true
//     });

//     $( ".spam_msg" ).live("click",function() {
//             bbs_id = $(this).attr('data-bbs_id');
//             $( "#msg_spam_form" ).dialog( "open" );
//     });

//     $("#msg_send_spam, .spam_reason_link").click(function() {
//         if ( $(this).is("A") ) var text = $(this).text();
//         else var text = $('#msg_spam_text').val();

//         $.post("/spam.php", { action: 'spam_msg', bbs_id: bbs_id, text: text  },
//         function(data){
//             if ($.trim(data) != "ok") {
//                 alert(data);
//             }
//             else {
//                 $( "#msg_spam_form" ).dialog( "close" );
//                 alert("Спасибо! Ваша жалоба отправлена администрации сайта.\nМы постараемся обработать её в ближайшее время, но не можем гарантировать точные сроки.");
//             }
//         });
//         return false;
//     });
// });
