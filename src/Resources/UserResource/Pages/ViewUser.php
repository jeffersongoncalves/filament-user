<?php

namespace JeffersonGoncalves\Filament\User\Resources\UserResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use JeffersonGoncalves\Filament\User\Resources\UserResource;
use JeffersonGoncalves\Filament\User\Resources\UserResource\Actions\ImpersonateUserAction;
use JeffersonGoncalves\Filament\User\Resources\UserResource\Pages\Concerns\ResolvesResource;

class ViewUser extends ViewRecord
{
    use ResolvesResource;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImpersonateUserAction::page()->record($this->getRecord()),
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
