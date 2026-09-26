<?php

namespace JeffersonGoncalves\Filament\User\Resources\Users\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\Filament\User\Resources\Users\Pages\Concerns\ResolvesResource;
use JeffersonGoncalves\Filament\User\Resources\Users\UserResource;

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
