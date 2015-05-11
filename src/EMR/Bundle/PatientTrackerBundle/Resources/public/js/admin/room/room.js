$(function () {
    var site_form = $('#site_form');
    var dialog = $('#roomsDialog').dialog({autoOpen: false, modal: true,
        buttons: {
            OK: function () {
                var form = $(this).find('form');
                $.post(form.attr('action'), form.serialize(), function (data) {
                    if (data) {
                        form.html($(data).find('form'));
                        console.log('error');
                    } else {
                        console.log('success');
                        dialog.dialog('close');
                        site_form.submit();
                    }
                });
            }
        }});
    site_form.on('change', 'select', function () {
        site_form.submit();
    });
    site_form.submit(function (event) {
        event.preventDefault();
        $.post(site_form.attr('action'), site_form.serialize(), function (data) {
            $('#Rooms').html(data);
        });
    });
    $('#Rooms').on('click', 'a.newRoom', function (event) {
        event.preventDefault();
        $.get($(this).attr('href'), function (data) {
            dialog.html($(data).find('form'));
            dialog.dialog('open');
        }, 'html');
    });

    site_form.submit();
});