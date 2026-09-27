<?php

namespace JeffersonGoncalves\Filament\User\Resources\UserResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use JeffersonGoncalves\Filament\User\Resources\UserResource;
use JeffersonGoncalves\Filament\User\Resources\UserResource\Pages\Concerns\ResolvesResource;

class CreateUser extends CreateRecord
{
    use ResolvesResource;

    protected static string $resource = UserResource::class;
}
