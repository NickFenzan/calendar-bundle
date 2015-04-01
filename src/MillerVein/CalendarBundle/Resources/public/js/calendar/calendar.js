var calendar = {};
calendar.ajax = {
    appointment_new_form: function(type, data, callback) {
        var route = Routing.generate('appointment_new_form', {type: type});
        $.get(route, data, callback);
    },
    appointment_edit_form: function(type, id, callback, data) {
        var route = Routing.generate('appointment_edit_form', {type: type, id: id});
        $.get(route, data, callback);
    },
    appointment_info: function(type, id, callback) {
        var route = Routing.generate('appointment_info', {type: type, id: id});
        $.get(route, callback);
    },
    appointment_finder_search: function(data, callback) {
        var route = Routing.generate('appointment_finder_search');
        $.post(route, data, callback);
    },
    calendar_ajax_post: function(data, callback) {
        var route = Routing.generate('calendar_ajax_post');
        $.post(route, data, callback);
    },
    category_columns: function(id, callback) {
        var route = Routing.generate('category_columns',{id: id});
        $.post(route, callback);
    },
    category_duration: function(id, data, callback) {
        var route = Routing.generate('category_duration',{id: id});
        $.get(route, data, callback);
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
    paperwork_button: null,
    preop_button: null,
    secondary_controls: null,
    form: null,
    _create: function() {
        this.previous_button = this.element.find('.previousDay');
        this.next_button = this.element.find('.nextDay');
        this.find_appointment_button = this.element.find('.findAppointment');
        this.date_input = this.element.find('.date_input');
        this.date_span = this.element.find('.date_span');
        this.site_input = this.element.find('.site_input');
        this.show_cancelled = this.element.find('.show_cancelled');
        this.show_more = this.element.find('.show_more');
        this.paperwork_button = this.element.find('.paperwork_button');
        this.preop_button = this.element.find('.preop_button');
        this.secondary_controls = this.element.find('.secondary');
        this.form = this.element.find('form');
        this.element.find('a, button').button();

        this._on(this.previous_button, {
            click: function(event) {
                event.preventDefault();
                var date = moment(this.date_input.val(), 'MM-DD-YYYY').subtract(1, 'days');
                this.date_input.val(date.format('MM/DD/YYYY')).change();
            }
        });
        this._on(this.next_button, {
            click: function(event) {
                event.preventDefault();
                var date = moment(this.date_input.val(), 'MM-DD-YYYY').add(1, 'days');
                this.date_input.val(date.format('MM/DD/YYYY')).change();
            }
        });
        this._on(this.find_appointment_button, {
            click: function(event) {
                event.preventDefault();
                calendar.appointment_finder.appointment_finder('open');
            }
        });
        this._on(this.date_span, {
            click: function() {
                this.date_input.datepicker('show');
            }
        });
        this._on(this.date_input, {
            change: function() {
                var date = moment(this.date_input.val(), 'MM/DD/YYYY');
                this.date_span.text(date.format('dddd MM/DD/YYYY'));
                this.submit();
            }
        });
        this._on(this.site_input, {
            change: function() {
                this.submit();
            }
        });
        this._on(this.show_cancelled, {
            change: function() {
                this.submit();
            }
        });
        this._on(this.show_more, {
            click: function(event) {
                event.preventDefault();
                this.secondary_controls.toggle(300);
            }
        });
        this._refresh();
    },
    //These 2 functions should obviously be fixed but its no big deal right now
    _paperworkLinkUpdate: function(){
        var address = "/interface/paperwork/paperwork.php?mode=todaysAppointments";
        var date = moment(this.date_input.val(), 'MM/DD/YYYY');
        address += "&PWdate=" + date.format('YYYY-MM-DD');
        address += "&PWsite=" + this.site_input.val();
        this.paperwork_button.attr('href',address);
    },
    _preopLinkUpdate: function(){
        var address = "/interface/paperwork/paperwork.php?mode=preop";
        var date = moment(this.date_input.val(), 'MM/DD/YYYY');
        address += "&PWdate=" + date.format('YYYY-MM-DD');
        address += "&PWsite=" + this.site_input.val();
        this.preop_button.attr('href',address);
    },
    changeDate: function(date) {
        this.date_input.val(date).change();
    },
    submit: function() {
        var that = this;
        calendar.ajax.calendar_ajax_post(this.form.serialize(), function(data) {
            calendar.calendar.replaceWith(data);
            calendarInit();
            that._refresh();
        });
    },
    _refresh: function() {
        this._paperworkLinkUpdate();
        this._preopLinkUpdate();
    }
});
$.widget('millerveincalendar.appointment_dialog', $.ui.dialog, {
    form: null,
    appointment_type_select: null,
    column_input: null,
    category_input: null,
    time_input: null,
    duration_input: null,
    paperwork_button: null,
    reminder_button: null,
    save_button: null,
    options: {
        autoOpen: false,
        modal: true,
        width: "450px",
        mode: 'new',
        type: 'patient',
        appt_id: null,
        appt_options: null
    },
    _create: function(){
        this.refresh();
        this._super();
    },
    _setOption: function(key, value) {
        console.log(key + ' : ' + value);
        if (key === 'mode') {
            if (value === 'new') {
                console.log('new');
                this.options.appt_id = null;
            } else if (value === 'edit') {
                console.log('edit');
                this.options.appt_options = null;
            }
        }
        this._super(key, value);
    },
    _setOptions: function(options) {
        this._super(options);
        this._checkState();
    },
    _checkState: function(){
        if (this.options.mode === 'new' && this.options.appt_options !== null) {
            calendar.ajax.appointment_new_form(this.options.type, this.options.appt_options,$.proxy(this._redraw,this));
        } else if (this.options.mode === 'edit' && this.options.appt_id !== null) {
            calendar.ajax.appointment_edit_form(this.options.type, this.options.appt_id, $.proxy(this._redraw,this));
        }
    },
    _redraw: function(data){
        if(data.action==='refreshForm'){
            this.element.html(data.html);
            runGlobalEnhancements();
            this.refresh();
        }else if(data.action==='refreshCalendar'){
            calendar.controls.calendar_controls('submit');
            this.close();
        }
    },
    _columnCategoryUpdate: function(){
        var that = this;
        if(this.column_input.val()){
            calendar.ajax.category_columns(this.column_input.val(),function(data){
                if(that.options.mode==='edit'){
                    var selected = that.category_input.find('option:selected');
                }
                that.category_input.html(data);
                if(that.options.mode==='edit' && selected){
                    that.category_input.find('[value="'+selected.attr('value')+'"]').remove();
                    that.category_input.prepend(selected);
                }
                that._durationUpdate();
            });
        }
    },
    _durationUpdate: function(){
        var data = {
            date: this.time_input.val(),
            column: this.column_input.val()
        };
        var that = this;
        calendar.ajax.category_duration(this.category_input.val(),data,function(data){
            if(that.options.mode==='edit'){
                    var selected = that.duration_input.find('option:selected');
                }
                that.duration_input.html(data);
                if(that.options.mode==='edit' && selected){
                    that.duration_input.find('[value="'+selected.attr('value')+'"]').remove();
                    that.duration_input.prepend(selected);
                }
        });
    },
    _paperworkButtonCheck: function(){
        if(this.options.type === 'patient'){
            var paperworkLink = '/interface/paperwork/paperwork.php?appts[]=' + this.options.appt_id + '&mode=appointment';
            var reminderLink = '/interface/paperwork/paperwork.php?appts[]=' + this.options.appt_id + '&papers[]=papers-Face%20Sheet';
            this.paperwork_button.attr('href',paperworkLink);
            this.reminder_button.attr('href',reminderLink);
            this.paperwork_button.show();
            this.reminder_button.show();
        }else{
            this.paperwork_button.hide();
            this.reminder_button.hide();
        }
    },
    refresh: function() {
        this.element.find('a,button').button();
        this.form = this.element.find('form');
        this.appointment_type_select = this.element.find('#appointment-type');
        this.paperwork_button = this.element.find('.paperwork_button');
        this.reminder_button = this.element.find('.reminder_button');
        this.save_button = this.element.find('.save_button');
        this.category_input = this.element.find('.category_input');
        this.column_input = this.element.find('.column_input');
        this.time_input = this.element.find('.time_input');
        this.duration_input = this.element.find('.duration_input');
        this._columnCategoryUpdate();
        this._paperworkButtonCheck();
        this._on(this.element.find('button'),{
            "click": function(event){
                event.preventDefault();
            }
        });
        this._on(this.appointment_type_select,{
            "change": function(event){
                this.options.type = $(event.target).val();
                this._checkState();
            }
        });
        this._on(this.category_input,{
            "change": this._durationUpdate
        });
        this._on(this.save_button,{
            "click": function(){
                if(this.options.mode === 'new'){
                    calendar.ajax.appointment_new_form(this.options.type,this.form.serialize(),$.proxy(this._redraw,this));
                }else{
                    calendar.ajax.appointment_edit_form(this.options.type,this.options.appt_id,$.proxy(this._redraw,this),this.form.serialize());
                }
            }
        })
    }
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
        var options = {
            mode: 'edit',
            type: type,
            appt_id: id
        }
        calendar.appointment_dialog.appointment_dialog('option', options);
        calendar.appointment_dialog.appointment_dialog('open');
//        });
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
        var options = {
            mode: 'new',
            type: 'patient',
            "appt_options": {
                datetime: this.element.data('datetime'),
                column: this.element.data('column')
            }
        };
        calendar.appointment_dialog.appointment_dialog('option', options);
        calendar.appointment_dialog.appointment_dialog('open');
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
                var date = $(event.target).data('datetime');
                calendar.controls.calendar_controls('changeDate', date);
                this.close();
                var options = {
                    mode: 'new',
                    type: 'patient',
                    appt_options: {
                        datetime: $(event.target).data('datetime'),
                        column: $(event.target).data('column')
                    }
                };
                calendar.appointment_dialog.appointment_dialog('option', options);
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

        calendar.calendar.delayOn('scroll', function(event) {
            var currentScroll = calendar.calendar.scrollLeft();
            calendar.calendar.scrollLeft(Math.round(currentScroll / 600) * 600);
        }, 50);
    };
    calendarInit();

});