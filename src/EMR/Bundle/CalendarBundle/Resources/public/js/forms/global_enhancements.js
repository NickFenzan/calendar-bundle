function runGlobalEnhancements() {
    var $allDatepickers = $('[data-hasDatepicker="true"]');
    if (!$allDatepickers.data("ui-datepicker")) {
        $allDatepickers.datepicker({
            changeMonth: true,
            changeYear: true,
        });
    }

    $(".patient_selector").keydown(function(event) {
        if ($(this).data('option_selected')) {
            $(this).val('');
            $(this).data('option_selected',false);
        }
    });
    $(".patient_selector").autocomplete({
        source: Routing.generate('patient_selector'),
        minLength: 2,
        create: function(){
            if($(this).val().length > 0){
                $(this).data('option_selected',true);
            }else{
                $(this).data('option_selected',false);
            }
        },
        select: function(){
            $(this).data('option_selected',true)
        }
    });
};
$(function() {
    runGlobalEnhancements();
});