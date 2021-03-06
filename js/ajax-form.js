/**
 * Function for send from data as ajax-requests
 * @example onsubmit='return ajax_submit(this)'
 *
 * @param form
 * @returns {boolean}
 */
function ajax_submit(form) {
    var forma = $(form);
    var action = forma.attr('action');
    var form_data = forma.serialize();
    $.ajax({
        type: 'POST',
        url: action,
        timeout: 30000,
        data: form_data,
        beforeSend: function () {
            forma.attr('disabled', 'disabled');
            if (forma.find('fieldset').length) {
                forma.find('fieldset').attr('disabled', 'disabled');
            }
        },
        success: function (msg) {

            ajax_response(msg);

            forma.removeAttr('disabled');
            if (forma.find('fieldset').length) {
                forma.find('fieldset').removeAttr('disabled');
            }
        },

        error: function (xhr, status, error) {

            forma.removeAttr('disabled');

            if (forma.find('fieldset').length) {
                forma.find('fieldset').removeAttr('disabled');
            }

            console.log(xhr);

            swal('Ошибка AJAX запроса!', 'Ooops! Что-то пошло не так...');
        }
    });
    return false;
}

function ajax_response(msg) {
    var obj;
    try {
        obj = JSON.parse(msg);
    }
    catch (e) {
        console.log(e);

        swal('Ошибка AJAX запроса.', 'Ooops! Что-то пошло не так...');
        return;
    }

    if (obj.function) {
        if (obj.data) {
            if (obj.data.length === 2) {
                window[obj.function](obj.data[0], obj.data[1]);
            }
            else {
                window[obj.function](obj.data);
            }
        }
        else {
            window[obj.function]();
        }
    }
    else {
        swal(obj.data);
    }
}

function reload() {
    window.location.reload();
}

function redirect(url) {
    window.location.href = url;
}

function warning(text) {
    swal(text, '', 'warning');
}