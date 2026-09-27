<?php

namespace JeffersonGoncalves\Filament\User\Resources\UserResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\Filament\User\Resources\UserResource;
use JeffersonGoncalves\Filament\User\Resources\UserResource\Actions\ImpersonateUserAction;
use JeffersonGoncalves\Filament\User\Resources\UserResource\Pages\Concerns\ResolvesResource;

class EditUser extends EditRecord
{
    use ResolvesResource;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImpersonateUserAction::page()->record($this->getRecord()),
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
