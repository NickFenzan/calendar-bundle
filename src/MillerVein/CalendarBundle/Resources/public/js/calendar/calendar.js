var calendar = {};
calendar.ajax = {
    appointment_new_form: function(type, data, callback) {
        var route = Routing.generate('appointment_new_form', {type: type});
        $.get(route, data, callback);
    },
    appointment_edit_form: function(type, id, callback) {
        var route = Routing.generate('appointment_edit_form', {type: type, id: id});
        $.get(route, callback);
    },
    appointment_info: function(type, id, callback) {
        var route = Routing.generate('appointment_info', {type: type, id: id});
        $.get(route, callback);
    },
    appointment_finder_search: function(data, callback) {
        var route = Routing.generate('appointment_finder_search');
        $.post(route, data, callback);
    },
    calendar_ajax_post: function(data,callback){
        var route = Routing.generate('calendar_ajax_post');
        $.post(route, data, callback);
    }
};

$.widget('millerveincalendar.calendar_controls', {
    previous_button: null,
    next_button: null,
    find_appointment_button: null,
    date_input: null,
    date_span: null,
    site_input: null,
    show_cancelled: null,
    show_more: null,
    secondary_controls: null,
    form: null,
    _create:function(){
        this.previous_button = this.element.find('.previousDay');
        this.next_button = this.element.find('.nextDay');
        this.find_appointment_button = this.element.find('.findAppointment');
        this.date_input = this.element.find('.date_input');
        this.date_span = this.element.find('.date_span');
        this.site_input = this.element.find('.site_input');
        this.show_cancelled = this.element.find('.show_cancelled');
        this.show_more = this.element.find('.show_more');
        this.secondary_controls = this.element.find('.secondary');
        this.form = this.element.find('form');
        this.element.find('a, button').button();
        
        this._on(this.previous_button,{
            click: function(event){
                event.preventDefault();
                var date = moment(this.date_input.val(), 'MM-DD-YYYY').subtract(1, 'days');
                this.date_input.val(date.format('MM/DD/YYYY')).change();
            }
        });
        this._on(this.next_button,{
            click: function(event){
                event.preventDefault();
                var date = moment(this.date_input.val(), 'MM-DD-YYYY').add(1, 'days');
                this.date_input.val(date.format('MM/DD/YYYY')).change();
            }
        });
        this._on(this.find_appointment_button,{
            click: function(event){
                event.preventDefault();
                calendar.appointment_finder.appointment_finder('open');
            }
        });
        this._on(this.date_span,{
            click: function(){
                this.date_input.datepicker('show');
            }
        });
        this._on(this.date_input,{
            change: function(){
                var date = moment(this.date_input.val(), 'MM/DD/YYYY');
                this.date_span.text(date.format('dddd MM/DD/YYYY'));
                this.submit();
            }
        });
        this._on(this.site_input,{
            change: function(){
                this.submit();
            }
        });
        this._on(this.show_cancelled,{
            change: function(){
                this.submit();
            }
        });
        this._on(this.show_more,{
            click: function(event){
                event.preventDefault();
                this.secondary_controls.toggle(300);
            }
        });
    },
    submit: function(){
        calendar.ajax.calendar_ajax_post(this.form.serialize(),function(data){
            calendar.calendar.replaceWith(data);
            calendarInit();
        });
    }
});
$.widget('millerveincalendar.appointment_dialog', $.ui.dialog, {
    form: null,
    appointment_type_select: null,
    data: {},
    options: {
        autoOpen: false,
        modal: true,
        width: "450px"
    },
    _create: function() {
        $.proxy(this, this.elementsInit);
        return this._super();
    },
    _elementsInit: function() {
        this.form = this.element.find('.appt_form');
        this.appointment_type_select = this.element.find('#appointment-type');
        this._on(this.appointment_type_select, {
            "change": function() {
                var type = this.appointment_type_select.val();
                var that = this;
                calendar.ajax.appointment_new_form(type, this.data, function(data) {
                    that.setFormHtml($(data).find('.appt_form').html());
                });
            }
        });
    },
    setData: function(data) {
        this.data = data;
    },
    setFormHtml: function(data) {
        this.form.html(data);
        runGlobalEnhancements();
    },
    setHtml: function(data) {
        this.element.html(data);
        this._elementsInit();
        this.open();
        runGlobalEnhancements();
    },
});
$.widget('millerveincalendar.appointment', {
    options: {
        appointment_dialog: null,
        tooltip: {
            track: true,
            show: false,
            content: '...',
            open: function(event, ui) {
                var _elem = ui.tooltip;
                var id = $(this).data('id');
                var type = $(this).data('type');
                calendar.ajax.appointment_info(type, id, function(data) {
                    _elem.find(".ui-tooltip-content").html(data);
                });
            }
        }
    },
    _create: function() {
        this.element.tooltip(this.options.tooltip);
        if (this.options.appointment_dialog === null) {
            console.log('Appointment Button improperly initialized. Missing dialog reference.');
        }
        this._on({
            dblclick: this._openEditAppointmentDialog,
            taphold: this._openEditAppointmentDialog,
            mouseenter: "_hover",
            mouseleave: "_hover"
        });
    },
    _hover: function(e) {
        if (e.type === "mouseenter")
        {
            var id = this.element.data('id')
            $('.appt[data-id="' + id + '"]').addClass('appointment-hover');
        }
        if (e.type === "mouseleave")
        {
            var id = this.element.data('id')
            $('.appt[data-id="' + id + '"]').removeClass('appointment-hover');
        }
    },
    _openEditAppointmentDialog: function() {
        var id = this.element.data('id');
        var type = this.element.data('type');
        var that = this;
        calendar.ajax.appointment_edit_form(type, id, function(data) {
            that.options.appointment_dialog.appointment_dialog('setHtml', data);
        });
    }
});
$.widget('millerveincalendar.time_button', {
    options: {
        appointment_dialog: null
    },
    _create: function() {
        if (this.options.appointment_dialog === null) {
            console.log('Appointment Button improperly initialized. Missing dialog reference.');
        }
        this._on({
            "click": this._openNewAppointmentDialog,
        });
    },
    _openNewAppointmentDialog: function() {
        var data = {
            datetime: this.element.data('datetime'),
            column: this.element.data('column')
        };
        this.options.appointment_dialog.appointment_dialog('setData', data);
        var that = this;
        calendar.ajax.appointment_new_form('patient', data, function(data) {
            that.options.appointment_dialog.appointment_dialog('setHtml', data);
        });
    }
});
$.widget('millerveincalendar.appointment_finder', $.ui.dialog, {
    results: null,
    resultsLoading: null,
    form: null,
    options: {
        autoOpen: false,
        modal: true,
        width: '600px'
    },
    _create: function() {
        this.form = this.element.find('form');
        this.results = $('<div>').addClass('results');
        this.element.append(this.results);
        this.resultsLoading = $('<div>').addClass('resultsLoading');
        this.element.append(this.resultsLoading);
        this.resultsLoading.progressbar({value: false});

        this._on(this.element, {
            "click .result": function(event) {
                var date = $(event.target).data('date');
                calendar.date_input.val(date).change();
                this.close();
                calendar.appointment_dialog.appointment_dialog('open');
            }
        });

        this._on(this.element.find('.go'), {
            click: function(event) {
                event.preventDefault();
                this.resultsLoading.show();
                this.results.empty();
                var that = this;
                calendar.ajax.appointment_finder_search(this.form.serialize(), function(data) {
                    that.resultsLoading.hide();
                    console.log(data.status);
                    that.results.html(data.html);
                });
            }
        });
        return this._super();
    }
});

$(function() {
    calendarInit = function() {
//        calendar.date_input = $('#controls .date_input');
        calendar.calendar = $('#calendar');
        calendar.controls = $('#controls').calendar_controls();
        calendar.appointment_dialog = $('#appointment-dialog').appointment_dialog();
        calendar.appointment_finder = $('#appointmentFinder-dialog').appointment_finder();
        $('.appt').appointment({appointment_dialog: calendar.appointment_dialog});
        $('.time').time_button({appointment_dialog: calendar.appointment_dialog});

        var calendarColumnBodies = $(".calendar-column .column-body");
        calendarColumnBodies.scroll(function() {
            calendarColumnBodies.scrollTop($(this).scrollTop());
        });

        $('#calendar').delayOn('scroll', function(event) {
            var currentScroll = $('#calendar').scrollLeft();
            $('#calendar').scrollLeft(Math.round(currentScroll / 600) * 600);
        }, 50);
    };
    calendarInit();

});