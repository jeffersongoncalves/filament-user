<?php

namespace JeffersonGoncalves\Filament\User\Resources\Users\Actions;

use Filament\Facades\Filament;
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
        $plugin = static::plugin();

        return TableImpersonate::make()
            ->guard($plugin->getImpersonateGuard())
            ->redirectTo($plugin->getImpersonateRedirectTo());
    }

    public static function page(): PageImpersonate
    {
        $plugin = static::plugin();

        return PageImpersonate::make()
            ->guard($plugin->getImpersonateGuard())
            ->redirectTo($plugin->getImpersonateRedirectTo());
    }

    protected static function plugin(): UserPlugin
    {
        return Filament::getCurrentPanel()?->hasPlugin('filament-user') ? UserPlugin::get() : UserPlugin::make();
    }
}
