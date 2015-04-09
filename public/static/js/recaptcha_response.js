var onloadCallback = function () {
    grecaptcha.render('recaptcha-tag', {
        'sitekey' : recaptcha_site_key,
        'callback' : verifyCallback,
    }); 
};

var verifyCallback = function (response) {
    $('.btn.btn-primary').attr('disabled', false);
};

