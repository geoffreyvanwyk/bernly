Dear Sir/Madam,

Thank you for registering an account on {{ config('app.url') }}.

Please click the following link to verify that you own this email address:
{{ config('app.url') }}/verify/email?address={{ rawurlencode(auth()->user()->email) }}&token={{ $token }} .

Without email verification, URLs you shorten cannot be associated with your account, which means you will lose the benefit of registration.

Kind regards,
The Bernly Team
