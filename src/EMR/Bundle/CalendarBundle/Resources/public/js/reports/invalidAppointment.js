$(function () {
    $('#apptEdit').dialog({
        autoOpen: false,
        modal: true
    });
    $('#editApptButton').click(function () {
        var id = $(this).data('id');
        var route = Routing.generate('appointment_patient_edit_form', {appt: id});
        $.get(route, function (data) {
            $('#apptEdit').html(data.html);
            $('#apptEdit').dialog('open');
        });
    });
});