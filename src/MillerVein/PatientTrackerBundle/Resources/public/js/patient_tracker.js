timingCheck();
(function statusPoll() {
    setTimeout(function () {
        timingCheck();
        statusPoll();
    }, 10000);
})();

var $site = $('#siteDiv').find('select');

$site.change(updateRooms);
updateRooms();
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

$(".room ul").on("sortreceive", function (event, ui) {
    var data = {};
    data.id = ui.item.data('id');
    data.site = $('#site').val();
    data.room = $(this).attr('id');
    $.post("ajaxStep.php", data);
});

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