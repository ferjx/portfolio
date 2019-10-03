$(function() {
		$(".favorite_add").live("click",function () {
				var bbs_id = $(this).attr('data-bbs_id');
				if (bbs_id) {
						$.get(
								vip_site, { 'id': $(this).attr('data-bbs_id'), 'favorite': $.cookie("favorite") },
								function(ret){
										console.log(ret);
										if (ret.status == 0) {
												if (ret.data != '') alert(ret.data);
										}
										else {
												$(".favorite_popover[data-bbs_id="+bbs_id+"]").webuiPopover('show');
												// console.log($(".favorite_add[bbs_id="+bbs_id+"] img").attr('src'));
												$(".favorite_add[data-bbs_id="+bbs_id+"] img").attr('src', favorite_image_on);
												// console.log($(".favorite_add[bbs_id="+bbs_id+"] img").attr('src'));
												$(".favorite_add[data-bbs_id="+bbs_id+"]").attr('title','Удалить из избранного');
												$(".favorite_add[data-bbs_id="+bbs_id+"]").attr('class','favorite_del');
												if ($(".favorites_all")) $(".favorites_all").html('('+ret.data.count+')');
										}
						},
						'json');
				}

				return false;
		});

		$(".favorite_del").live("click",function () {
				var bbs_id = $(this).attr('data-bbs_id');
				if ($(this).attr('data-bbs_id')) {
						$.get(vip_site, { 'id': $(this).attr('data-bbs_id'), 'favorite': $.cookie("favorite") },
								function(ret){
										if (ret.status == 0) {
												if (ret.data != '') alert(ret.data);
										}
										else {
												$(".favorite_popover[data-bbs_id="+bbs_id+"]").webuiPopover('hide');
												$(".favorite_del[data-bbs_id="+bbs_id+"] img").attr('src', favorite_image_off);
												$(".favorite_del[data-bbs_id="+bbs_id+"]").attr('title','Добавить в избранное');
												$(".favorite_del[data-bbs_id="+bbs_id+"]").attr('class','favorite_add');
												if ($(".favorites_all")) {
														if (ret.data.count <= 0) $(".favorites_all").html('');
														else $(".favorites_all").html('('+ret.data.count+')');
												}
										}
								},
								'json');
				}

				return false;
		});
		
});