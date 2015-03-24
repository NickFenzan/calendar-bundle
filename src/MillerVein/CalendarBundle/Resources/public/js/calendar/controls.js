$(function() {
    $('#calendar-datespan').click(function() {
        $('#calendar-dateinput').datepicker('show');
    });
    $('#calendar-dateinput').change(submitCalendarControls);
    $('#calendar-siteinput').change(submitCalendarControls);
    $('#calendar-showcancelled').change(submitCalendarControls);
    function submitCalendarControls(){
        $(this).parents('form').submit();
    }
});