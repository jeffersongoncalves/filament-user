<?php

namespace JeffersonGoncalves\Filament\User\Tests\Fixtures;

use Filament\Http\Middleware\Authenticate;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Session\Middleware\StartSession;
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
            ->middleware([
                StartSession::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                UserPlugin::make(),
            ]);
    }
}
