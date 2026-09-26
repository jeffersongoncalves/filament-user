<?php

namespace JeffersonGoncalves\Filament\User\Resources\Users\Pages;

use Filament\Resources\Pages\CreateRecord;
use JeffersonGoncalves\Filament\User\Resources\Users\Pages\Concerns\ResolvesResource;
use JeffersonGoncalves\Filament\User\Resources\Users\UserResource;

class CreateUser extends CreateRecord
{
    use ResolvesResource;

    protected static string $resource = UserResource::class;
}
