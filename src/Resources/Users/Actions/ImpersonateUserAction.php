<?php

namespace JeffersonGoncalves\Filament\User\Resources\Users\Actions;

use JeffersonGoncalves\Filament\User\UserPlugin;
use STS\FilamentImpersonate\Actions\Impersonate;

class ImpersonateUserAction
{
    public static function make(): Impersonate
    {
        $plugin = UserPlugin::current();

        return Impersonate::make()
            ->guard($plugin->getImpersonateGuard())
            ->redirectTo($plugin->getImpersonateRedirectTo())
            ->hidden(! $plugin->isImpersonationEnabled());
    }
}
