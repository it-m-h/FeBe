export function onEditButtonClick() {
    $('#UserListe .edit').click(function () {
        var id = $(this).parent().attr('data-id');
        $.ajax({
            type: "GET",
            url: "/App/User/getUser/" + id,
            dataType: 'json',
            success: function (response) {
                if (response['error']) {
                    M.toast({ html: response['error'], classes: 'red' });
                } else {
                    $('#user_id').val(response['user_id']);
                    $('#user_id').addClass('valid');
                    $('#user_pfad').val(response['user_pfad']);
                    $('#user_pfad').addClass('valid');
                    $('#user_name').val(response['user_name']);
                    $('#user_name').addClass('valid');
                    $('#user_passwort').val(response['user_passwort']);
                    $('#user_passwort').addClass('valid');
                    $('#user_gruppe').val(response['user_gruppe']);
                    $('#user_gruppe').addClass('valid');
                    $('#user_RFID').val(response['user_RFID']);
                    $('#user_RFID').addClass('valid');
                    M.toast({ html: 'Daten geladen', classes: 'grey darken-2' });
                    M.updateTextFields();
                    $('select').formSelect();
                }
            }
        });
    });
}
export function onStatusButtonClick() {
    $('#UserListe .status').click(function () {
        abfrage = confirm("Benutzer aktivieren/deaktivieren?");
        if (abfrage == false) {
            return false;
        } else {
            var id = $(this).parent().attr('data-id');
            $.ajax({
                type: "GET",
                url: "/App/User/toggleUserStatus/" + id,
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
    $('#UserForm #clear').click(function () {
        $('#UserForm').find('input').each(function () {
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
        var form = $('#UserForm');
        var url = form.attr('action');
        var data = form.serialize();
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response['success']) {
                    $('#UserForm').find('input').each(function () {
                        var value = $(this).attr('value');
                        $(this).val(value);
                    });
                    M.toast({ html: 'Gespeichert', classes: 'green darken-2' });
                    setTimeout(function () {
                        location.reload();
                    }, 700);

                } else if (response['error']) {
                    console.log(response);
                    if (!Array.isArray(response['error'])) {
                        M.toast({ html: response['error'], classes: 'red' });
                    } else {
                        for (let key in response.data) {
                            let value = response.data[key];
                            M.toast({ html: key + ': ' + value, classes: 'red' });
                        }
                    }
                }
            }
        });
    });
}