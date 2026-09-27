<?php

namespace JeffersonGoncalves\Filament\User\Resources\UserResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\Filament\User\Resources\UserResource;
use JeffersonGoncalves\Filament\User\Resources\UserResource\Pages\Concerns\ResolvesResource;

class ListUsers extends ListRecords
{
    use ResolvesResource;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
