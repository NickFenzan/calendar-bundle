$(function() {
    $('#controls button, #controls a').button();
    
    $('#appointmentFinder-dialog').dialog({
        autoOpen: false,
        modal: true,
        width: '600px'
    });
    
    $('#appointmentFinder-dialog .resultsLoading').progressbar({
        value: false
    });
    $('#appointmentFinder-dialog .go').click(function(event){
        event.preventDefault();
        $('#appointmentFinder-dialog .resultsLoading').show();
        $('#appointmentFinder-dialog .results').empty();
        var route = Routing.generate('appointment_finder_search');
        var form = $('#appointmentFinder-dialog form');
        $.post(route,form.serialize(),function(data){
            $('#appointmentFinder-dialog .resultsLoading').hide();
            console.log(data.status);
            $('#appointmentFinder-dialog .results').html(data.html);
        });
    });
    
    $('#appointmentFinder-dialog').on('click','.result',function(){
        var date = $(this).data('date');
        $('#calendar-dateinput').val(date);
        $('#calendar-dateinput').change();
        $('#appointmentFinder-dialog').dialog('close');
        $('#appointment-dialog').dialog('open');
    });
    
    
    $('#findAppointment').click(function(event){
        event.preventDefault();
        $('#appointmentFinder-dialog').dialog('open');
    });
    
    $('#calendar-datespan').click(function() {
        $('#calendar-dateinput').datepicker('show');
    });
    $('#calendar-dateinput').change(function(){
        var date = moment($('#calendar-dateinput').val(),'MM/DD/YYYY');
        $('#calendar-datespan').text(date.format('dddd MM/DD/YYYY'));
        submitCalendarControls();
    });
    $('#calendar-siteinput').change(submitCalendarControls);
    $('#calendar-showcancelled').change(submitCalendarControls);
    $('#showMore').click(function(event){
        event.preventDefault();
        $('#controls .secondary').toggle(300);
    });
    
    $('#previousDay').click(function(event){
        event.preventDefault();
        
        var date = moment($('#calendar-dateinput').val(),'MM-DD-YYYY').subtract(1,'days');
        $('#calendar-dateinput').val(date.format('MM/DD/YYYY'));
        $('#calendar-dateinput').change();
    });
    $('#nextDay').click(function(event){
        event.preventDefault();
        
        var date = moment($('#calendar-dateinput').val(),'MM-DD-YYYY').add(1,'days');
        $('#calendar-dateinput').val(date.format('MM/DD/YYYY'));
        $('#calendar-dateinput').change();
    });
    function submitCalendarControls(){
        var form = $('#controls').find('form');
        var route = Routing.generate('calendar_ajax_post');
        $.post(route,form.serialize(),function(data){
            $('#calendar').replaceWith(data);
            calendarInit();
        });
    }
});