Dear Sir/Madam,

Thank you for registering an account on {{ Config::get( 'app.url' ) }}.

Please click the following link to verify that you own this email address: 
{{ Config::get( 'app.url' ) }}/verify/email?address={{ rawurlencode(Auth::user()->email) }}&token={{ $token }} .

Kind regards,
The Bernly Team
