<?php

namespace Modules\Account\Concerns\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords as BaseResetsPasswords;
use Illuminate\Http\Request;

trait ResetsPasswords
{
    use BaseResetsPasswords;

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('account::auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
