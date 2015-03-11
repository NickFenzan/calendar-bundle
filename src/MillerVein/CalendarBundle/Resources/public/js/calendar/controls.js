$(function() {
    $('#calendar-datespan').click(function() {
        $('#calendar-dateinput').datepicker('show');
    });
    $('#calendar-dateinput').change(function(){
        $(this).parents('form').submit();
    });
    $('#calendar-siteinput').change(function(){
        $(this).parents('form').submit();
    });
});