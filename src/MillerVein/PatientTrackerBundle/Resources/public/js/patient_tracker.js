timingCheck();
(function statusPoll() {
    setTimeout(function () {
        timingCheck();
        statusPoll();
    }, 10000);
})();


$(".room ul").sortable({
    connectWith: ".room ul",
});
function timingCheck() {
    var site = $('#site').val();
    console.log("Site: " + site);
    $.post("timingCheck.php", {site: site}, function (data) {
        console.log(JSON.stringify(data));
        $(".room ul").empty();
        $.each(data, function (room, pats) {
            var $roomUl = $('#' + room);
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
$('#site').change(timingCheck);

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