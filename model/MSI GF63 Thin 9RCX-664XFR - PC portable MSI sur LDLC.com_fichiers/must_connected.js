function getLoginForm(successCallback) {
    $.ajax({
        method: 'GET',
        url: Routing.generate('login_form', {'_locale': request_locale, 'country': request_country}, true),
        success: function (data) {
            if (typeof successCallback === "function") {
                successCallback(data);
                $('#VerificationToken').ldlcvc();
            }
        }
    });
}

function displayModalLoginForm(callbackSuccessLogin, redirectOnAccountCreationRequest)
{
    $('#secure-login-form').remove();
    getLoginForm(function(data) {
        $('#modal-login').modal('show');
        $('#modal-login .modal-body').html('<div id="secure-modal-login-form" class="open">' + data + '</div>');
        if (undefined !== redirectOnAccountCreationRequest) {
            $('.new-customer a.button').attr(
                'href',
                $('.new-customer a.button').attr('href') + '/?returnUrl='+redirectOnAccountCreationRequest
            )
        }

        bindLoginForm(callbackSuccessLogin);
    });
}

function bindLoginForm(callbackSuccessLogin)
{
    $(document).on('submit', '#secure-modal-login-form #loginForm', function (event) {
        event.preventDefault();
        postLoginForm($(this), true, callbackSuccessLogin);//modal
    });
}

function afterLoginSuccessAnimation(fromModal, data){
    $('#secure-login-form').remove();
    $('#compte').after(data.user_resume);
    if(fromModal){
        $('#secure-modal-login-form').remove();
        $('#modal-login').modal('hide');
    }else {
        $('#header-user-resume').addClass('open');
    }
    $('#compte').addClass('logged');
    $('#account-menu-item').addClass('logged');
    $('#logged-user-icon').removeClass('hidden');
    // Reload the homepage to show the birthday slide if needed
    if($('.cache-slides.birthday-enabled').length) {
        $.ajax({
            method: 'GET',
            url: Routing.generate('slider_is_birthday', {'_locale': request_locale, 'country': request_country}, true),
            success: function (data) {
                if(data.isBirthday) {
                    location.reload();
                }
            }
        })
    }
}

function postLoginForm(form, fromModal, callbackSuccessLogin) {
    $.ajax({
        data: form.serialize(),
        method: 'POST',
        url : Routing.generate('submit_login_form', {'_locale' : request_locale, 'country' : request_country}, true),
        success: function(data) {
            if (false == data.authenticationSuccess) {
                if(fromModal) {
                    $('#secure-modal-login-form').html(data.loginForm);
                    bindLoginForm(callbackSuccessLogin);
                } else {
                    if (true === data.mustRedirect){
                        window.location.href = $('#compte').attr('href');
                        return;
                    } else {
                        $('#secure-login-form').html(data.loginForm);
                    }
                }
                setValidateMessageClass('#loginForm');
            } else {
                afterLoginSuccessAnimation(fromModal ,data);
                if (typeof callbackSuccessLogin === "function") {
                    callbackSuccessLogin();
                }
            }
        }
    });
}

function setFieldError($formGroup) {
    $formGroup.removeClass('success').addClass('error');
    if ($formGroup.find('select, input:not(:checkbox,:hidden,:radio,.novalico)').length > 0) {
        if ($formGroup.find('span.icon').length === 0) {
            $formGroup.append('<span class="icon"></span>');
        }
        $formGroup.find('span.icon').removeClass('icon-success').addClass('icon-error');
    }
}

function setValidateMessageClass(parentId) {
    $(parentId + ' span.field-validation-valid, ' + parentId + ' span.field-validation-error').addClass('helper');
    $(parentId + ' .form-group').each(function () {
        setFieldError($(this));
    });
}
