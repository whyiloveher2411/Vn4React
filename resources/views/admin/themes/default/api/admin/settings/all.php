<?php
$__settings = setting();

unset($__settings['security_recaptcha_secret']);
unset($__settings['security_google_authenticator_secret']);
unset($__settings['security_google_authenticator_secret_img']);

return $__settings;