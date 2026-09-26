<?php

namespace JeffersonGoncalves\Filament\User\Tests\Fixtures;

use Filament\Panel;
use Filament\PanelProvider;
use JeffersonGoncalves\Filament\User\Pages\Auth\Login;
use JeffersonGoncalves\Filament\User\UserPlugin;

class TestPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('app')
            ->login(Login::class)
            ->plugins([
                UserPlugin::make(),
            ]);
    }
}
