<?php

namespace Modules\Account\Concerns\Auth;

use Illuminate\Foundation\Auth\VerifiesEmails as BaseVerifiesEmails;
use Illuminate\Http\Request;

trait VerifiesEmails
{
    use BaseVerifiesEmails;

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                        ? redirect($this->redirectPath())
                        : view('account::auth.verify');
    }
}
