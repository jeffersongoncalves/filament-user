<?php

namespace JeffersonGoncalves\Filament\User\Resources\Users\Pages\Concerns;

use Filament\Facades\Filament;
use JeffersonGoncalves\Filament\User\UserPlugin;

/**
 * Pages follow the resource configured on the plugin (UserPlugin::make()->resource(...)),
 * so an app subclass of UserResource keeps working without copying the pages.
 */
trait ResolvesResource
{
    public static function getResource(): string
    {
        $panel = Filament::getCurrentPanel();

        if ($panel?->hasPlugin('filament-user')) {
            return UserPlugin::get()->getResource();
        }

        return static::$resource;
    }
}
