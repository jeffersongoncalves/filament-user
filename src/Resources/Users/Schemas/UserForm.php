<?php

namespace JeffersonGoncalves\Filament\User\Resources\Users\Schemas;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use function filled;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->columns()
                    ->schema(static::components()),
            ]);
    }

    /**
     * Override (or merge with parent::components()) to add fields.
     *
     * @return array<int, Component|Field>
     */
    public static function components(): array
    {
        return [
            Toggle::make('status')
                ->label(__('filament-user::user.fields.status'))
                ->required()
                ->default(true)
                ->autofocus(),
            TextInput::make('name')
                ->label(__('filament-user::user.fields.name'))
                ->required()
                ->string()
                ->autofocus(),
            TextInput::make('email')
                ->label(__('filament-user::user.fields.email'))
                ->required()
                ->string()
                ->unique(ignoreRecord: true)
                ->email(),
            TextInput::make('password')
                ->label(__('filament-user::user.fields.password'))
                ->password()
                ->required(fn (string $context): bool => $context === 'create')
                ->dehydrated(fn ($state) => filled($state))
                ->minLength(6),
        ];
    }
}
