$(function() {
    $('#controls button, #controls a').button();
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