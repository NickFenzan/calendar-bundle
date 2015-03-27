var calendar = {};

calendar.controls = {
    appointment_dialog: {
        elem: null,
        init: function() {
            this.elem.dialog({
                autoOpen: false,
                modal: true,
                width: "450px"
            });
        }
    },
    init: function() {
        this.appointment_dialog.init();
    }
};


var calendarInit;
$(function() {
    calendar.controls.appointment_dialog.elem = $('#appointment-dialog');
    calendar.controls.init();
    calendarInit = function() {
        var $apptDialog = $('#appointment-dialog');
//        $apptDialog.dialog({
//            autoOpen: false,
//            modal: true,
//            width: "450px"
//        });

        $('.time').click(function() {
            var data = {
                datetime: $(this).data('datetime'),
                column: $(this).data('column')
            };
            calendar.controls.appointment_dialog.elem.data('apptInfo', data);
            var route = Routing.generate('appointment_new_form', {type: "patient"});
            $.get(route, data, setDialogCallback);
        });
        $('.appt').on("dblclick taphold", function() {
            var id = $(this).data('id');
            var type = $(this).data('type');
            var route = Routing.generate('appointment_edit_form', {type: type});
            $.get(route + '/' + id, setDialogCallback);
        });

        function setDialogCallback(data) {
            calendar.controls.appointment_dialog.elem.html(data);
            calendar.controls.appointment_dialog.elem.dialog('open');
            runGlobalEnhancements();
        }

        calendar.controls.appointment_dialog.elem.on('change', '#appointment-type', function() {
            var type = $(this).val();
            var data = calendar.controls.appointment_dialog.elem.data('apptInfo');
            var route = Routing.generate('appointment_new_form', {type: type});
            $.get(route, data, function(data) {
                calendar.controls.appointment_dialog.elem.find('.appt_form').html($(data).find('.appt_form').html());
                runGlobalEnhancements();
            });
        });

        $('.appt').tooltip({
            track: true,
            show: false,
//        position: { my: "left+15 top", at: "right center" },
            content: '...',
            open: function(event, ui) {
                var _elem = ui.tooltip;
                var id = $(this).data('id');
                var type = $(this).data('type');
                var route = Routing.generate('appointment_info', {type: type});
                console.log(route + '/' + id);
                $.get(route + '/' + id, function(data) {
                    _elem.find(".ui-tooltip-content").html(data);
                });
            }
        });
        $('.appt').hover(function() {
            var id = $(this).data('id');
            $('.appt[data-id="' + id + '"]').addClass('appointment-hover');
        }, function() {
            var id = $(this).data('id');
            $('.appt[data-id="' + id + '"]').removeClass('appointment-hover');
        });

        var calendarColumnBodies = $(".calendar-column .column-body");
        calendarColumnBodies.scroll(function() {
            calendarColumnBodies.scrollTop($(this).scrollTop());
        });

        var lastScroll = 0;
        $('#calendar').delayOn('scroll', function(event) {
            var currentScroll = $('#calendar').scrollLeft();
            $('#calendar').scrollLeft(Math.round(currentScroll / 600) * 600);
        }, 50);
    };
    calendarInit();

});