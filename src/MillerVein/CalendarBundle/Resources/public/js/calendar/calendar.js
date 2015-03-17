$(function() {
    var $apptDialog = $('#appointment-dialog');
    $apptDialog.dialog({
        autoOpen: false,
        modal: true
    });
    $('.time').click(function() {
        var data = {
            datetime: $(this).data('datetime'),
            column: $(this).data('column')
        };
        $apptDialog.data('apptInfo', data);
        var route = Routing.generate('appointment_patient_new_form');
        $.get(route, data, setDialogCallback);
    });
    $('.appt').click(function() {
        var id = $(this).data('id');
        var type = $(this).data('type');
        var route = Routing.generate('appointment_' + type + '_edit_form');
        $.get(route + '/' + id, setDialogCallback);
    });

    function setDialogCallback(data) {
        $apptDialog.html(data);
        $apptDialog.dialog('open');
        runGlobalEnhancements();
    }

    $apptDialog.on('change', '#appointment-type', function() {
        var type = $(this).val();
        var data = $apptDialog.data('apptInfo');
        var route = Routing.generate('appointment_' + type + '_new_form');
        $.get(route, data, function(data) {
            $apptDialog.find('.appt_form').html($(data).find('.appt_form').html());
        });
    });
});