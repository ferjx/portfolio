function show_metro(city_id,metro_id) {
    $("#metro_id").html("");
    $("#metrodiv").hide();
    if (city_id > 0 && metro[city_id] != undefined && metro[city_id].length > 0) {
        var gen_metro = '<option value="0">Выберите метро</option>';
        $.each(metro[city_id], function(i,oMetro) {
            selected = oMetro.id == metro_id ? 'selected' : '';
            gen_metro += '<option ' + selected + ' value="' + oMetro.id + '">' + oMetro.name + '</option>';
        });
        $("#metro_id").html(gen_metro);
        $("#metrodiv").show();
    }
}