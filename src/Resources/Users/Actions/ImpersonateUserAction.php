<?php

namespace JeffersonGoncalves\Filament\User\Resources\Users\Actions;

use Filament\Facades\Filament;
use JeffersonGoncalves\Filament\User\UserPlugin;
use STS\FilamentImpersonate\Actions\Impersonate;

class ImpersonateUserAction
{
    public static function make(): Impersonate
    {
        $plugin = Filament::getCurrentPanel()?->hasPlugin('filament-user') ? UserPlugin::get() : UserPlugin::make();

        return Impersonate::make()
            ->guard($plugin->getImpersonateGuard())
            ->redirectTo($plugin->getImpersonateRedirectTo());
    }
}
