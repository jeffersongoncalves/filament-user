<?php

namespace JeffersonGoncalves\Filament\User\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \JeffersonGoncalves\Filament\User\PanelAccess using(?\Closure $callback)
 * @method static bool check(\Illuminate\Database\Eloquent\Model $user, \Filament\Panel $panel)
 *
 * @see \JeffersonGoncalves\Filament\User\PanelAccess
 */
class PanelAccess extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \JeffersonGoncalves\Filament\User\PanelAccess::class;
    }
}
