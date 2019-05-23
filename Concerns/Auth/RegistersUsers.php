<?php

namespace Modules\Account\Concerns\Auth;

use Illuminate\Foundation\Auth\RegistersUsers as BaseRegistersUsers;

trait RegistersUsers
{
    use BaseRegistersUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('account::auth.register');
    }
}
