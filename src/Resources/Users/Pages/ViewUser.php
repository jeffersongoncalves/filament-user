<?php

namespace JeffersonGoncalves\Filament\User\Resources\Users\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use JeffersonGoncalves\Filament\User\Resources\Users\Actions\ImpersonateUserAction;
use JeffersonGoncalves\Filament\User\Resources\Users\Pages\Concerns\ResolvesResource;
use JeffersonGoncalves\Filament\User\Resources\Users\UserResource;

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
