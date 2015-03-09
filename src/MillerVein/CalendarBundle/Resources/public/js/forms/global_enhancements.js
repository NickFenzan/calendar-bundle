$(function() {
    var $allDatepickers = $('form input[name*=date]');
    if (!$allDatepickers.data("ui-datepicker")) {
        $allDatepickers.datepicker();
    }
});