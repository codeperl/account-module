<?php

namespace Modules\Account\Concerns\Auth;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails as BaseSendsPasswordResetEmails;

trait SendsPasswordResetEmails
{
    use BaseSendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('account::auth.passwords.email');
    }
}
