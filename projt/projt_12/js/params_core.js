$(function () {
    var ParamsHeadersArr = $.parseJSON(ParamsHeaders);
    var ParamsDataArr = $.parseJSON(ParamsData);
    if ($.trim($('#params').html()) == '') $('#params').hide();
    else $('#params').show();

    $('#cat_id').change(function () {
        var val = $('#cat_id :selected').val().split('_');
        var params_show = [];
        podrazdel = val[1];
        $('#params').empty();
        if (ParamsHeadersArr[podrazdel]) {
            $.each(ParamsHeadersArr[podrazdel], function (i, v) {
                var check_ot_do = v.name.substr(v.name.length - 4, 4);
                if (check_ot_do != ': до') {
                    if (check_ot_do != ': от') {
                        GenSelect = '<div class="param_element"><select id="param_data' + i + '" param="' + i + '" name="paramdata[' + i + ']"><option value="">' + v.name + '</option>';
                        if (ParamsDataArr[i]) {
                            $.each(ParamsDataArr[i], function (pid, dataO) {
                                if (pid != 'child') {
                                    GenSelect += '<option value="' + dataO.id + '">' + dataO.value + '</option>';
                                }
                            });
                        }
                        GenSelect += '</select></div>';
                        if (!(v.prior in params_show)) params_show[v.prior] = GenSelect;
                        else params_show.push(GenSelect);
                        //$('#params').append(GenSelect);
                    }
                    else {
                        var name_param = v.name.substr(0, v.name.length - 4);
                        var Input = '<div class="param_element">' +
                                '<input type="text" placeholder="'+name_param+'" title="'+name_param+'" name="paramdata[' + i + ']">' +
                                '<span>'+v.example+'</span>' +
                            '</div>';
                        if (!(v.prior in params_show)) params_show[v.prior] = Input;
                        else params_show.push(Input);
                        //$('#params').append(Input);
                    }
                }
            });
            $.each(params_show, function (i, v) {
                $('#params').append(v);
            });
            params_show = [];
        }
        if ($('#params').html() == '') $('#params').hide();
        else $('#params').show();
    });

    $('#params [name*="paramdata"]').live("change", function () {
        var val = $('#cat_id :selected').val().split('_');
        podrazdel = val[1];
        var value_id = $(this).val();
        var param_id = $(this).attr("param");
        if (ParamsHeadersArr[podrazdel] && ParamsHeadersArr[podrazdel][param_id] && ParamsHeadersArr[podrazdel][param_id]['child']) {
            $.each(ParamsHeadersArr[podrazdel][param_id]['child'], function (i) {
                $('#param_data' + i).remove();
            });
        }
        if (ParamsDataArr[param_id] && ParamsDataArr[param_id]['child'] && ParamsDataArr[param_id]['child'][value_id]) {
            newparam = ParamsDataArr[param_id]['child'][value_id][0]['param_id'];
            GenSelect = '<select id="param_data' + newparam + '" param="' + newparam + '" name="paramdata[' + newparam + ']"><option value="">' + ParamsHeadersArr[podrazdel][param_id]['child'][newparam].name + '</option>';
            $.each(ParamsDataArr[param_id]['child'][value_id], function (pid, dataO) {
                GenSelect += '<option value="' + dataO.id + '">' + dataO.value + '</option>';
            });
            GenSelect += '</select>';
            $('#param_data' + param_id).after(GenSelect);
        }

    });
});
