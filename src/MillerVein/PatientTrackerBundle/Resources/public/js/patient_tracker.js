var $site = $('#siteDiv').find('select');

$site.change(updateRooms);

$('#roomsDiv').on("sortreceive", '.room ul', function (event, ui) {
    var room = $(this).parents('.room');
    if(room.hasClass('checked-out')){
        var data = {visit : ui.item.data('id')};
        var addStepRoute = Routing.generate('patient_tracker_checkout',data);
        $.get(addStepRoute,updateRooms);
    }else{
        var data = {};
        data.visit = ui.item.data('id');
        data.room = $(this).parents('.room').attr('id');
        var addStepRoute = Routing.generate('patient_tracker_add_step');
        $.post(addStepRoute, data, updateRooms);
    }
});

updateRooms();
timingCheck();

function updateRooms(){
    var form = $('#siteDiv').find('form');
    $.post(form.attr('action'), form.serialize(), function (data) {
        $('#roomsDiv').html(data);
        $(".room ul").sortable({
            connectWith: ".room ul",
        });
        timingCheck();
    });
}

function timingCheck() {
    var site = $('#siteDiv').find('select').val();
    console.log("Site: " + site);
    var timingCheckRoute = Routing.generate('patient_tracker_timing_check', {site: site});
    $.get(timingCheckRoute, function (data) {
        $(".room ul").empty();
        $.each(data, function (room, pats) {
            console.log(room);
            var $roomUl = $('#' + room).find('ul');
            $.each(pats, function (i, line) {
                $roomUl.append(line);
            });
        });
    }, 'json');
}

(function fakeTimers() {
    setTimeout(function () {
        $(".stepTime").each(function () {
            var text = $(this).text();
            var ss = text.split(":");
            var dt = new Date();
            dt.setHours(ss[0]);
            dt.setMinutes(ss[1]);
            dt.setSeconds(ss[2]);
            var dt2 = new Date(dt.valueOf() + 1000);
            var ts = dt2.toTimeString().split(" ")[0];
            $(this).text(ts);
        });
        fakeTimers();
    }, 1000);
})();

(function statusPoll() {
    setTimeout(function () {
        timingCheck();
        statusPoll();
    }, 10000);
})();