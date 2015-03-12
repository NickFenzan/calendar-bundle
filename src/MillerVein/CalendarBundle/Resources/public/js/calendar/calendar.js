$(function(){
    var $apptDialog = $('#appointment-dialog');
    $apptDialog.dialog({
        autoOpen: false,
        modal: true
    });
    $('.time').click(function(){
        var data = {
            datetime: $(this).data('datetime'),
            column: $(this).data('column')
        };
        $.get('calendar/appointment/new',data,function(data){
            $apptDialog.html(data);
            $apptDialog.dialog('open');
        });
    });
    $('.appt').click(function(){
        var id = $(this).data('id');
        $.get('calendar/appointment/edit/'+id,function(data){
            $apptDialog.html(data.form);
            $apptDialog.dialog('open');
        });
    });
});