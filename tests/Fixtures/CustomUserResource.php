<?php

namespace JeffersonGoncalves\Filament\User\Tests\Fixtures;

use JeffersonGoncalves\Filament\User\Resources\UserResource;

class CustomUserResource extends UserResource
{
    protected static ?string $slug = 'members';
}
