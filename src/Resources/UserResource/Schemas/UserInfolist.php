<?php

namespace JeffersonGoncalves\Filament\User\Resources\UserResource\Schemas;

use Filament\Infolists\Components\Component;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use JeffersonGoncalves\Filament\AdditionalInformation\AdditionalInformation;

class UserInfolist
{
    public static function configure(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(1)
            ->schema([
                Section::make()
                    ->columns()
                    ->schema(static::components()),
                AdditionalInformation::make([
                    'created_at',
                    'updated_at',
                ]),
            ]);
    }

    /**
     * Override (or merge with parent::components()) to add entries.
     *
     * @return array<int, Component>
     */
    public static function components(): array
    {
        return [
            TextEntry::make('id')
                ->label(__('filament-user::user.fields.id')),
            IconEntry::make('status')
                ->label(__('filament-user::user.fields.status'))
                ->boolean(),
            TextEntry::make('name')
                ->label(__('filament-user::user.fields.name')),
            TextEntry::make('email')
                ->label(__('filament-user::user.fields.email'))
                ->copyable()
                ->copyMessage(__('filament-user::user.email_copied'))
                ->copyMessageDuration(1500),
        ];
    }
}
