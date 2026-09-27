<?php

namespace JeffersonGoncalves\Filament\User\Resources\UserResource\Actions;

use JeffersonGoncalves\Filament\User\UserPlugin;
use STS\FilamentImpersonate\Pages\Actions\Impersonate as PageImpersonate;
use STS\FilamentImpersonate\Tables\Actions\Impersonate as TableImpersonate;

/**
 * Filament v3 has separate table and page actions for impersonation.
 */
class ImpersonateUserAction
{
    public static function table(): TableImpersonate
    {
        $plugin = UserPlugin::current();

        return TableImpersonate::make()
            ->guard($plugin->getImpersonateGuard())
            ->redirectTo($plugin->getImpersonateRedirectTo())
            ->hidden(! $plugin->isImpersonationEnabled());
    }

    public static function page(): PageImpersonate
    {
        $plugin = UserPlugin::current();

        return PageImpersonate::make()
            ->guard($plugin->getImpersonateGuard())
            ->redirectTo($plugin->getImpersonateRedirectTo())
            ->hidden(! $plugin->isImpersonationEnabled());
    }
}
