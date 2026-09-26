<?php

namespace JeffersonGoncalves\Filament\User\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;

/**
 * Only active (status = true) accounts can sign in.
 */
class Login extends BaseLogin
{
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => $data['email'],
            'password' => $data['password'],
            'status' => true,
        ];
    }
}
