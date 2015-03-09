$.widget("millervein.by_day", {
    inputs: {
        byDay: null,
        everyDay: null,
        positiveDays: null,
        negativeDays: null,
    },
    _create: function() {
        this.inputs.byDay = this.element.find('[name*="[byDay]"]');
        this.inputs.everyDay = this.element.find('[name*="[byDayChoice]"]');
        this.inputs.positiveDays = this.element.find('[name*="[byDayPositiveRelative]"]');
        this.inputs.negativeDays = this.element.find('[name*="[byDayNegativeRelative]"]');
        
        this._on(this.inputs.everyDay, {
            change: $.proxy(this.everyDay.change, this)
        });
        this._on('input', {
            change: this.refreshValue
        });
        
        $.proxy(this.initialize, this)();
    },
    everyDay: {
        change: function(){
            var that = this;
            $.each(this.inputs.everyDay,function(i, val){
                if($(this).prop("checked")){
                    $.proxy(that.positiveDays.disableDay, that, $(this).val())();
                    $.proxy(that.negativeDays.disableDay, that, $(this).val())();
                }else{
                    $.proxy(that.positiveDays.enableDay, that, $(this).val())();
                    $.proxy(that.negativeDays.enableDay, that, $(this).val())();
                }
            });
//            that.refreshValue();
        }
    },
    positiveDays: {
        disableDay: function(day){
            this.inputs.positiveDays.filter('[value*="'+day+'"]').each(function(){
                $(this).prop('checked',false);
                $(this).prop('disabled',true);
            });
        },
        enableDay: function(day){
            this.inputs.positiveDays.filter('[value*="'+day+'"]').each(function(){
                $(this).prop('disabled',false);
            });
        },
        disable: function(){
            this.inputs.positiveDays.prop('disabled',true);
            this.inputs.positiveDays.prop('checked',false);
            this.inputs.positiveDays.parents('.by_day_container').hide();
        },
        enable: function(){
            this.inputs.positiveDays.prop('disabled',false);
            this.inputs.positiveDays.parents('.by_day_container').show();
        }
    },
    negativeDays: {
        disableDay: function(day){
            this.inputs.negativeDays.filter('[value*="'+day+'"]').each(function(){
                $(this).prop('checked',false);
                $(this).prop('disabled',true);
            });
        },
        enableDay: function(day){
            this.inputs.negativeDays.filter('[value*="'+day+'"]').each(function(){
                $(this).prop('disabled',false);
            });
        },
        disable: function(){
            this.inputs.negativeDays.prop('disabled',true);
            this.inputs.negativeDays.prop('checked',false);
            this.inputs.negativeDays.parents('.by_day_container').hide();
        },
        enable: function(){
            this.inputs.negativeDays.prop('disabled',false);
            this.inputs.negativeDays.parents('.by_day_container').show();
        }
    },
    disableRelative: function(){
        $.proxy(this.positiveDays.disable,this)();
        $.proxy(this.negativeDays.disable,this)();
        console.log('disable relative');
    },
    enableRelative: function(){
        $.proxy(this.positiveDays.enable,this)();
        $.proxy(this.negativeDays.enable,this)();
    },
    initialize: function(){
        var text = this.inputs.byDay.val();
        var arr = text.split(',');
        this.inputs.everyDay.each(function(){
            if (arr.indexOf($(this).val()) > -1){
                $(this).prop('checked',true);
            }else{
                $(this).prop('checked',false);
            }
        });
        this.inputs.positiveDays.each(function(){
            if (arr.indexOf($(this).val()) > -1){
                $(this).prop('checked',true);
            }else{
                $(this).prop('checked',false);
            }
        });
        this.inputs.negativeDays.each(function(){
            if (arr.indexOf($(this).val()) > -1){
                $(this).prop('checked',true);
            }else{
                $(this).prop('checked',false);
            }
        });
    },
    refreshValue: function(){
        var vals = [];
        this.inputs.everyDay.each(function(){
            if($(this).prop('checked')){
                vals.push($(this).val());
            }
        });
        this.inputs.positiveDays.each(function(){
            if($(this).prop('checked')){
                vals.push($(this).val());
            }
        });
        this.inputs.negativeDays.each(function(){
            if($(this).prop('checked')){
                vals.push($(this).val());
            }
        });
        this.inputs.byDay.val(vals.join(','));
    }
    
    
});
$.widget("millervein.recurrance_rule", {
    inputs: {
        freq: null,
        endMethod: null,
        interval: null,
        until: null,
        count: null,
        byMonth: null,
        byWeekNo: null,
        byYearDay: null,
        byMonthDay: null,
        byDay: null,
        byHour: null,
        byMinute: null
    },
    displaySpans: {
        intervalUnit: null
    },
    _create: function() {
        this.inputs.freq = this.element.find('[name*="[freq]"]');
        this.inputs.endMethod = this.element.find('[name*="[endMethod]"]');
        this.inputs.interval = this.element.find('[name*="[interval]"]');
        this.inputs.until = this.element.find('[name*="[until]"]');
        this.inputs.count = this.element.find('[name*="[count]"]');
        this.inputs.byMonthText = this.element.find('[name*="[byMonth]"]');
        this.inputs.byMonthCheckboxes = this.element.find('[name*="[byMonthChoice]"]');
        this.inputs.byWeekNo = this.element.find('[name*="[byWeekNo]"]');
        this.inputs.byYearDay = this.element.find('[name*="[byYearDay]"]');
        this.inputs.byMonthDay = this.element.find('[name*="[byMonthDay]"]');
        this.inputs.byDay = this.element.find('.by_day_widget').by_day();
        this.inputs.byHour = this.element.find('[name*="[byHour]"]');
        this.inputs.byMinute = this.element.find('[name*="[byMinute]"]');

        this.displaySpans.intervalUnit = this.element.find('[class="intervalUnit"]');
        
        this.inputs.until.datepicker();

        this._on(this.inputs.endMethod, {
            change: $.proxy(this.endMethod.change, this)
        });
        
        this._on(this.inputs.freq, {
            change: $.proxy(this.freq.change, this)
        });
        
        this._on(this.inputs.byWeekNo, {
            change: $.proxy(this.byWeekNo.change, this)
        });
        
        this._on(this.inputs.byMonthCheckboxes, {
            change: $.proxy(this.byMonth.change, this)
        });
        
        $.proxy(this.byMonth.initialize,this)();
        
        this.inputs.endMethod.change();
        this.inputs.freq.change();
        this.inputs.byWeekNo.change();
    },
    freq: {
        change: function() {
            switch (this.inputs.freq.val()) {
                case "YEARLY":
                    this.utility.enable(this.inputs.byWeekNo);
                    this.utility.enable(this.inputs.byMonthDay);
                    this.utility.enable(this.inputs.byYearDay);
                    this.displaySpans.intervalUnit.text('years');
                    this.inputs.byDay.by_day("enableRelative");
                    console.log("Yearly triggered");
                break;
                case "MONTHLY":
                    this.utility.disable(this.inputs.byWeekNo);
                    this.utility.enable(this.inputs.byMonthDay);
                    this.utility.disable(this.inputs.byYearDay);
                    this.displaySpans.intervalUnit.text('months');
                    this.inputs.byDay.by_day("enableRelative");
                    console.log("Monthly triggered");
                break;
                case "WEEKLY":
                    this.utility.disable(this.inputs.byWeekNo);
                    this.utility.disable(this.inputs.byMonthDay);
                    this.utility.disable(this.inputs.byYearDay);
                    this.displaySpans.intervalUnit.text('weeks');
                    this.inputs.byDay.by_day("disableRelative");
                    console.log("Weekly triggered");
                break;
                case "DAILY":
                    this.utility.disable(this.inputs.byWeekNo);
                    this.utility.enable(this.inputs.byMonthDay);
                    this.utility.disable(this.inputs.byYearDay);
                    this.displaySpans.intervalUnit.text('days');
                    this.inputs.byDay.by_day("disableRelative");
                    console.log("Daily triggered");
                break;
            default:
                alert("Broken");
            }
        }
    },
    endMethod: {
        change: function() {
            switch (this.inputs.endMethod.val()) {
                case "forever": //Indefinite
                    this.utility.disable(this.inputs.count);
                    this.utility.disable(this.inputs.until);
                    break;
                case "count": //Count
                    this.utility.enable(this.inputs.count);
                    this.utility.disable(this.inputs.until);
                    break;
                case "until": //End Date
                    this.utility.disable(this.inputs.count);
                    this.utility.enable(this.inputs.until);
                    break;
            }
        }
    },
    byWeekNo: {
        change: function(){
            var val = this.inputs.byWeekNo.val();
            if(this.inputs.freq.val() === "YEARLY"){
                if(val.length > 0){
                    this.inputs.byDay.by_day('disableRelative');
                }else{
                    this.inputs.byDay.by_day('enableRelative');
                }
            }
        }
    },
    byMonth: {
        change: function(){
            var vals = [];
            this.inputs.byMonthCheckboxes.each(function(){
                if($(this).prop('checked')){
                    vals.push($(this).val());
                }
            });
            this.inputs.byMonthText.val(vals.join(','));
        },
        initialize: function(){
            var text = this.inputs.byMonthText.val();
            var arr = text.split(',');
            this.inputs.byMonthCheckboxes.each(function(){
                if (arr.indexOf($(this).val()) > -1){
                    $(this).prop('checked',true);
                }else{
                    $(this).prop('checked',false);
                }
            });
        }
    },
    utility: {
        disable: function(input){
            input.val('');
            input.parents('tr').hide();
        },
        enable: function(input){
            input.parents('tr').show();
        }
    }
});
$(function() {
    $('form .recurrance_rule_widget').recurrance_rule();
});