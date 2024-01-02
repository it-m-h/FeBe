export function onEditButtonClick() {
    /*  .edit click */
    $('#GroupListe .edit').click(function () {
        var id = $(this).parent().attr('data-id');
        $.ajax({
            type: "GET",
            url: "/App/Group/getGroup/" + id,
            dataType: 'json',
            success: function (response) {
                if (response['error']) {
                    M.toast({ html: response['error'], classes: 'red' });
                } else {
                    $('#group_id').val(response['group_id']);
                    $('#group_id').addClass('valid');
                    $('#group_name').val(response['group_name']);
                    $('#group_name').addClass('valid');
                    $('#group_rights').val(response['group_rights']);
                    $('#group_rights').addClass('valid');
                    M.toast({ html: 'Daten geladen', classes: 'grey darken-2' });
                    M.updateTextFields();
                    $('select').formSelect();


                }
            }
        });
    });
}
export function onStatusButtonClick() {
    $('#GroupListe .status').click(function () {
        let abfrage = confirm("Gruppe aktivieren/deaktivieren?");
        if (abfrage == false) {
            return false;
        } else {
            var id = $(this).parent().attr('data-id');
            $.ajax({
                type: "GET",
                url: "/App/Group/toggleGroupStatus/" + id,
                dataType: 'json',
                success: function (response) {
                    if (response['error']) {
                        M.toast({ html: response['error'], classes: 'red' });
                    } else {
                        M.toast({ html: response['success'], classes: 'green' });
                        setTimeout(function () {
                            location.reload();
                        }, 700);
                    }
                }
            });
        }
    });
}
export function onClearButtonClick() {
    $('#GroupListe #clear').click(function () {
        $('#GroupForm').find('input').each(function () {
            var value = $(this).attr('value');
            $(this).val(value);
            $(this).removeClass('valid');
        });
        M.updateTextFields();
        $('select').formSelect();
        M.toast({ html: 'Formular geleert', classes: 'grey darken-2' });
    });
}
export function onFormSubmit() {
    $('form').submit(function (e) {
        e.preventDefault();
        var form = $('#GroupForm');
        var url = form.attr('action');
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: 'json',
            success: function (response) {
                if (response['success']) {
                    $('#GroupForm').find('input').each(function () {
                        var value = $(this).attr('value');
                        $(this).val(value);
                    });
                    M.toast({ html: 'Gespeichert', classes: 'green darken-2' });
                    setTimeout(function () {
                        location.reload();
                    }, 700);

                } else if (response['error']) {
                    for (let key in response.data) {
                        let value = response.data[key];
                        M.toast({ html: key + ': ' + value, classes: 'red' });
                    }
                }

            }
        });
    });
}