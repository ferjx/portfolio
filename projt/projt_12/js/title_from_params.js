function set_title_from_params(el) {
    var title = '';
    var params_res = [];

    params_arr = $("[name^='paramdata']");
    if (params_arr.length > 0) {
        $.each(params_arr, function (key, obj) {
            var name = $(obj).attr("name");
            re = /paramdata\[(\d+)\]/i;
            res = name.match(re);
            if (res == null) return;
            var param_id = res[1];
            var param_val = $(obj).val();
            var param_txt_val = '';

            if (param_val == '') return;

            switch(obj.tagName) {
                case "SELECT":
                    param_txt_val = $(obj).find("option:selected").text();
                    break;

                case "INPUT":
                    param_txt_val = param_val;
                    break;
            }

            params_res[params_res.length] = [param_id, param_val, param_txt_val];
        });

        var floor_arr_ids = ["134", "130"];
        var floors_arr_ids = ["136", "132"];
        var floor = '';
        var floors = '';
        for (var i = 0; i < params_res.length; i++) {
            if (floor_arr_ids.indexOf(params_res[i][0]) > -1 && params_res[i][2] != '') floor = params_res[i][2];
            if (floors_arr_ids.indexOf(params_res[i][0]) > -1 && params_res[i][2] != '') floors = params_res[i][2];
        }

        for (var i = 0; i < params_res.length; i++) {
            param_id = params_res[i][0];
            param_val = params_res[i][1];
            param_txt_val = params_res[i][2];
            if (txtParams[param_id] != undefined) {
                if (txtParams[param_id][param_val] == undefined) param_val = 0;
                if (txtParams[param_id][param_val] != undefined) {
                    if (floor_arr_ids.indexOf(param_id) > -1 && floor != '' && floors != '') {
                        if (txtParams[param_id][param_val]['title'].indexOf('%num%') != -1) {
                            param_txt_val = parseInt(floor) + '/' + parseInt(floors);
                            title += title == '' ? txtParams[param_id][param_val]['title'].replace("%num%", param_txt_val) : ', ' + txtParams[param_id][param_val]['title'].replace("%num%", param_txt_val);
                        }
                        else {
                            param_txt_val = floor + '/' + floors;
                            title += title == '' ? txtParams[param_id][param_val]['title'].replace("%str%", param_txt_val) : ', ' + txtParams[param_id][param_val]['title'].replace("%str%", param_txt_val);
                        }
                    }
                    else {
                        if (floors_arr_ids.indexOf(param_id) > -1 && floor != '' && floors != '') continue;
                        var zapyataya = txtParams[param_id][param_val]['zapyataya'] == 1 ? ', ' : ' ';
                        if (txtParams[param_id][param_val]['title'].indexOf('%num%') != -1) {
                            title += title == '' ? txtParams[param_id][param_val]['title'].replace("%num%", parseInt(param_txt_val)) : zapyataya + txtParams[param_id][param_val]['title'].replace("%num%", parseInt(param_txt_val));
                        }
                        else {
                            title += title == '' ? txtParams[param_id][param_val]['title'].replace("%str%", param_txt_val) : zapyataya + txtParams[param_id][param_val]['title'].replace("%str%", param_txt_val);
                        }
                    }
                }
            }
        }

        if (title != '') el.val(title);
    }
    return true;
}
