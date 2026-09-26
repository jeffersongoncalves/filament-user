<?php

namespace JeffersonGoncalves\Filament\User\Resources\Users\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\Filament\User\Resources\Users\Actions\ImpersonateUserAction;
use JeffersonGoncalves\Filament\User\Resources\Users\Pages\Concerns\ResolvesResource;
use JeffersonGoncalves\Filament\User\Resources\Users\UserResource;

class EditUser extends EditRecord
{
    use ResolvesResource;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImpersonateUserAction::make()->record($this->getRecord()),
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
