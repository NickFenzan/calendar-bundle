var calendar = {};
calendar.ajax = {
    appointment_patient_new_form: function(data, callback) {
        var route = Routing.generate('appointment_patient_new_form');
        $.get(route, data, callback);
    },
    appointment_patient_edit_form: function(id, callback, data) {
        var route = Routing.generate('appointment_patient_edit_form', {appt: id});
        $.get(route, data, callback);
    },
    appointment_patient_info: function(id, callback) {
        var route = Routing.generate('appointment_patient_info', {appt: id});
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
    patient_allowed_categories: function(id, callback) {
        var route = Routing.generate('patient_allowed_categories',{column: id});
        $.post(route, callback);
    },
    patient_allowed_duration: function(data, callback) {
        var route = Routing.generate('patient_allowed_duration');
        $.post(route, data, callback);
    },
    category_default_duration: function(id, callback) {
        var route = Routing.generate('category_default_duration',{id: id});
        $.get(route, callback);
    }
};

$.widget('emrcalendar.calendar_controls', {
    previous_button: null,
    next_button: null,
    find_appointment_button: null,
    date_input: null,
    date_span: null,
    site_input: null,
    show_cancelled: null,
    show_more: null,
    paperwork_button: null,
    staffing_button: null,
    today_button: null,
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
                this.staffing_button = this.element.find('.staffing_button');
        this.today_button = this.element.find('.today_button');
        this.preop_button = this.element.find('.preop_button');
        this.secondary_controls = this.element.find('.secondary');
        this.form = this.element.children('form');
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
        this._on(this.staffing_button, {
            click: function(event) {
                event.preventDefault();
                calendar.staffing_dialog.staffing_dialog('open');
            }
        });
        this._on(this.today_button, {
            click: function(event) {
                event.preventDefault();
                this.changeDate(new Date());
                this.submit();
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
        var dateM = moment(new Date(date));
        this.date_span.text(dateM.format('dddd MM/DD/YYYY'));
        this.date_input.val(dateM.format('MM/DD/YYYY'));
    },
    changeSite: function(site) {
        this.site_input.val(site);
    },
    submit: function() {
//        this.form.submit();
        var that = this;
        $.post(this.form.prop('action'),this.form.serialize(),function(data) {
            var calendarHTML = $(data).find('#calendar');
            calendar.calendar.replaceWith(calendarHTML);
            calendarInit();
            that._refresh();
        });
//        calendar.ajax.calendar_ajax_post(this.form.serialize(), );
    },
    getDate: function(){
        var dateM = moment(new Date(this.date_input.val()));
        return dateM.format('YYYY-MM-DD');
    },
    getSite: function(){
        return this.site_input.val();
    },
    _refresh: function() {
        this._paperworkLinkUpdate();
        this._preopLinkUpdate();
    }
});
$.widget('emrcalendar.appointment_dialog', $.ui.dialog, {
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
        if (key === 'mode') {
            if (value === 'new') {
                this.options.appt_id = null;
            } else if (value === 'edit') {
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
            calendar.ajax.appointment_patient_new_form(this.options.appt_options,$.proxy(this._redraw,this));
        } else if (this.options.mode === 'edit' && this.options.appt_id !== null) {
            calendar.ajax.appointment_patient_edit_form(this.options.appt_id, $.proxy(this._redraw,this));
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
            calendar.ajax.patient_allowed_categories(this.column_input.val(),function(data){
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
        var that = this;
        calendar.ajax.patient_allowed_duration(this.form.serialize(),function(data){
            if(that.options.mode==='edit'){
                    var selected = that.duration_input.find('option:selected');
                }
                that.duration_input.html(data);
                if(that.options.mode==='edit' && selected){
                    var previousSelected = that.duration_input.find('[value="'+selected.attr('value')+'"]');
                    if(previousSelected.length < 1){
                        that.duration_input.find('option').first().attr('selected','selected');
                    }else{
                        that.duration_input.val(selected.attr('value'));
                    }
//                    that.duration_input.prepend(selected); NO DON'T, DO THIS! THIS ALLOWS PEOPLE TO MESS THINGS UP! C'MON, SERIOUSLY
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
                $.post(this.form.prop('action'),this.form.serialize(),$.proxy(this._redraw,this));
//                if(this.options.mode === 'new'){
//                    calendar.ajax.appointment_patient_new_form(this.form.serialize(),$.proxy(this._redraw,this));
//                }else{
//                    calendar.ajax.appointment_patient_edit_form(this.options.type,this.options.appt_id,$.proxy(this._redraw,this),this.form.serialize());
//                }
                }
        })
    }
});
$.widget('emrcalendar.appointment', {
    options: {
        appointment_dialog: null,
        tooltip: {
            track: true,
            show: false,
            content: '...',
            open: function(event, ui) {
                var _elem = ui.tooltip;
                var id = $(this).data('id');
//                var type = $(this).data('type');
                calendar.ajax.appointment_patient_info(id, function(data) {
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
    }
});
$.widget('emrcalendar.time_button', {
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
$.widget('emrcalendar.appointment_finder', $.ui.dialog, {
    results: null,
    resultsLoading: null,
    category: null,
    duration: null,
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
        this.category = this.element.find('.apptFinderCategory');
        this.duration = this.element.find('.apptFinderDuration');
        this._on(this.element, {
            "click .result": function(event) {
                var site = $(event.target).data('site');
                var date = $(event.target).data('datetime');
                var that = this;
                $('body').on('initComplete',function(){
                    that.close();
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
                    $('body').off('initComplete');
                });
                calendar.controls.calendar_controls('changeSite', site);
                calendar.controls.calendar_controls('changeDate', date);
                calendar.controls.calendar_controls('submit');
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
                    that.results.html(data.html);
                });
            }
        });
        this._on(this.category,{
            change: this.refreshDefaultDuration
        });
        
        this.refreshDefaultDuration();
        
        return this._super();
    },
    refreshDefaultDuration: function(){
        var catId = this.category.val();
        var that = this;
        calendar.ajax.category_default_duration(catId, function(data){
            that.duration.val(data);
        });
    }
});
$.widget('emrcalendar.staffing_dialog', $.ui.dialog, {
    options: {
        autoOpen: false,
        modal: true,
        width: '600px'
    },
    open: function(){
        var that = this;
        console.log(calendar.controls);
        var data = {
            siteId:calendar.controls.calendar_controls('getSite'),
            date:calendar.controls.calendar_controls('getDate')
        };
        $.get('/interface/misc/staffingTable.php',data,function(data){
            that.element.html(data);
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
        calendar.staffing_dialog= $('#staffing-dialog').staffing_dialog();
        $('.appt').appointment({appointment_dialog: calendar.appointment_dialog});
        $('.time:not(.read-only)').time_button({appointment_dialog: calendar.appointment_dialog});

        var calendarColumnBodies = $(".calendar-column .column-body");
        calendarColumnBodies.scroll( $.throttle( 150, function() {
            calendarColumnBodies.scrollTop($(this).scrollTop());
        }));

        calendar.calendar.delayOn('scroll', function(event) {
            var currentScroll = calendar.calendar.scrollLeft();
            calendar.calendar.scrollLeft(Math.round(currentScroll / 600) * 600);
        }, 50);
        $('body').trigger('initComplete');
    };
    calendarInit();

});
