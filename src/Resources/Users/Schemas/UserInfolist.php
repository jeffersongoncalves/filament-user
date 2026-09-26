<?php

namespace JeffersonGoncalves\Filament\User\Resources\Users\Schemas;

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
            TextEntry::make('id'),
            IconEntry::make('status')
                ->boolean(),
            TextEntry::make('name'),
            TextEntry::make('email')
                ->copyable()
                ->copyMessage('Email copied successfully!')
                ->copyMessageDuration(1500),
        ];
    }
}
