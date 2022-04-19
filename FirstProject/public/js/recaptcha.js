function getSubmitButtons(form) {
    var buttons = form.querySelectorAll('button, input');
    var submitButtons = [];

    for (var i = 0; i < buttons.length; i++) {
        var button = buttons[i];
        if (button.getAttribute('type') == 'submit') {
            submitButtons.push(button);
        }
    }

    return submitButtons;
}

function bindChallengeToSubmitButtons(form, reCaptchaId) {
    getSubmitButtons(form).forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            grecaptcha.execute(reCaptchaId);
        });
    });
}

function renderReCaptcha(widget) {
    var form = widget.closest('form');
    var widgetType = widget.getAttribute('data-type');
    var widgetParameters = {
        'sitekey': '{{ gg_recaptcha_site_key }}'
    };

    if (widgetType == 'invisible') {
        widgetParameters['callback'] = function () {
            form.submit()
        };
        widgetParameters['size'] = "invisible";
    }

    var widgetId = grecaptcha.render(widget, widgetParameters);

    if (widgetType == 'invisible') {
        bindChallengeToSubmitButtons(form, widgetId);
    }
}